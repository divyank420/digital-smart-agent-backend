<?php

namespace App\Http\Controllers\api;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\DopAccount;
use App\Models\DopLot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DopController extends Controller
{
    public function getDopAccounts(Request $request)
    {

        // Decode filter safely
        $filter = json_decode($request->filter, true) ?? [];
        $user = Auth::user();

        // Base query for stats (scoped by company and agent if provided)
        $statsQuery = DopAccount::where('company_id', $user->company_id);
        if (!empty($request->dop_agent_id)) {
            $statsQuery->where('agent_id', $request->dop_agent_id);
        }

        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

        $stats = $statsQuery->selectRaw("
            COUNT(CASE WHEN last_deposit_date NOT BETWEEN ? AND ? THEN 1 END) as total_pending,
            COUNT(CASE WHEN status = 'ACTIVE' AND defaulter_installment > 0 THEN 1 END) as total_defaulter_accounts,
            COUNT(CASE WHEN status = 'ACTIVE' THEN 1 END) as total_active_accounts
        ", [$startOfMonth, $endOfMonth])->first();

        $statsData = [
            'total_pending' => $stats->total_pending ?? 0,
            'total_defaulter_accounts' => $stats->total_defaulter_accounts ?? 0,
            'total_active_accounts' => $stats->total_active_accounts ?? 0,
        ];

        // Main Accounts Query
        $accountsQuery = DopAccount::where('company_id', $user->company_id)
            ->when(!empty($request->dop_agent_id), function ($query) use ($request) {
                $query->where('agent_id', $request->dop_agent_id);
            })
            ->when(data_get($filter, 'search'), function ($query) use ($filter) {
                $searchTerm = $filter['search'];
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('account_name', 'like', "%{$searchTerm}%")
                        ->orWhere('short_code', 'like', "%{$searchTerm}%")
                        ->orWhere('account_no', 'like', "%{$searchTerm}%");
                });
            })
            // Fixed filter keys to match frontend payloads (lowercase / underscored)
            ->when(data_get($filter, 'selectedFilter') === 'defaulter', function ($query) {
                $query->where('defaulter_installment', '>', 0);
            })
            ->when(data_get($filter, 'selectedFilter') === 'pending', function ($query) {
                $query->where('remaining_installments', '>', 0);
            })
            ->when(data_get($filter, 'selectedFilter') === 'paid', function ($query) {
                $query->where('remaining_installments', '<=', 0);
            })
            ->when(data_get($filter, 'selectedFilter') === 'newly_added', function ($query) {
                $query->whereBetween('account_opening_date', [
                    Carbon::now()->subMonths(3)->startOfMonth(),
                    Carbon::now()->endOfMonth(),
                ]);
            })
            ->when(data_get($filter, 'dropdownFilter') === 'near_maturity', function ($query) {
                $query->whereBetween('maturity_date', [
                    today(),
                    today()->addMonths(3)
                ])->where('status', 'ACTIVE');
            });

        if ($request->type == 'list') {
            $accountsQuery->select('id', 'agent_id', 'account_no', 'account_name', 'monthly_amount', 'short_code', 'defaulter_installment');

            $accountsCollection = $accountsQuery->get();

            $data['accounts_by_acc_no'] = $accountsCollection->keyBy('account_no');
            $data['accounts_by_short_code'] = $accountsCollection->keyBy('short_code')->toArray();

            return Helper::sendResponse('Accounts List', 1, $data);
        } else {
            $accounts = $accountsQuery->get();
            return Helper::sendResponse('Accounts List', 1, [
                'accounts' => $accounts,
                'stats' => $statsData
            ]);
        }
    }

    public function lots(Request $request)
    {

        $user = Auth::user();
        $filterInput = $request->input('filter', []);
        $filter = is_string($filterInput)
            ? (json_decode($filterInput, true) ?? [])
            : (is_array($filterInput) ? $filterInput : []);

        $lots = DopLot::with('items')
            ->where('company_id', $user->company_id)
            ->when($request->dop_agent_id !== '', function ($query) use ($request) {
                $query->where('agent_id', $request->dop_agent_id);
            })
            ->when($request->status !== 'all', function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when(data_get($filter, 'month'), function ($query) use ($filter) {
                $query->whereMonth('created_at', $filter['month']);
            })
            ->when(data_get($filter, 'year'), function ($query) use ($filter) {
                $query->whereYear('created_at', $filter['year']);
            })
            ->latest()
            ->paginate(10);
        return Helper::sendResponse('Lots Listing', 1, $lots);
    }
}
