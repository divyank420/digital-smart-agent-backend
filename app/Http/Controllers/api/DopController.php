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
    public function dopDashboard(Request $request)
    {
        $user = Auth::user();
        $agentId = $request->dop_agent_id;
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

        $nextMonthStart = Carbon::now()->addMonth()->startOfMonth()->toDateString();
        $nextMonthEnd = Carbon::now()->addMonth()->endOfMonth()->toDateString();

        $comman = "status = 'Active' OR status = 'Hold' OR status = 'Completed'";
        $data = DopAccount::where('company_id', $user->company_id)
            ->where('agent_id', $agentId)
            ->selectRaw("
                    COUNT(id) as total_accounts,
                    COUNT(CASE WHEN {$comman} THEN 1 END) as total_portal_accounts,
                    SUM(CASE WHEN {$comman} THEN monthly_amount ELSE 0 END) as portfolio,

                    -- First Half Pending (Current Month: Start to End)
                    COUNT(CASE WHEN status = 'Active' AND collection_cycle = '1' AND next_due_date BETWEEN ? AND ? THEN 1 END) as f_pending_acc,
                    SUM(CASE WHEN status = 'Active' AND collection_cycle = '1' AND next_due_date BETWEEN ? AND ? THEN monthly_amount ELSE 0 END) as f_pending_amt,
                    
                    -- First Half Paid (Next Month: Start to End)
                    COUNT(CASE WHEN status = 'Active' AND collection_cycle = '1' AND next_due_date BETWEEN ? AND ? THEN 1 END) as f_paid_acc,
                    SUM(CASE WHEN status = 'Active' AND collection_cycle = '1' AND next_due_date BETWEEN ? AND ? THEN monthly_amount ELSE 0 END) as f_paid_amt,

                    -- Second Half Pending (Current Month: Start to End)
                    COUNT(CASE WHEN status = 'Active' AND collection_cycle = '2' AND next_due_date BETWEEN ? AND ? THEN 1 END) as s_pending_acc,
                    SUM(CASE WHEN status = 'Active' AND collection_cycle = '2' AND next_due_date BETWEEN ? AND ? THEN monthly_amount ELSE 0 END) as s_pending_amt,
                    
                    -- Second Half Paid (Next Month: Start to End)
                    COUNT(CASE WHEN status = 'Active' AND collection_cycle = '2' AND next_due_date BETWEEN ? AND ? THEN 1 END) as s_paid_acc,
                    SUM(CASE WHEN status = 'Active' AND collection_cycle = '2' AND next_due_date BETWEEN ? AND ? THEN monthly_amount ELSE 0 END) as s_paid_amt,

                    COUNT(CASE WHEN status = 'Active' AND defaulter_installment > 0 AND defaulter_installment > 0 THEN 1 END) as def_acc,
                    SUM(CASE WHEN status = 'Active' AND defaulter_installment > 0 AND defaulter_installment <= 3 THEN (monthly_amount * defaulter_installment) ELSE 0 END) as def_amt,

                    COUNT(CASE WHEN status = 'Active' AND defaulter_installment > 3 THEN 1 END) as freeze_acc,
                    SUM(CASE WHEN status = 'Active' AND defaulter_installment > 3 THEN (monthly_amount * defaulter_installment) ELSE 0 END) as freeze_amt,

                    COUNT(CASE WHEN status = 'Active' AND next_due_date > ? THEN 1 END) as advance_acc,
                    SUM(CASE WHEN status = 'Active' AND next_due_date > ? THEN monthly_amount ELSE 0 END) as advance_amt,

                    COUNT(CASE WHEN status = 'Active' AND account_opening_date >= ? THEN 1 END) as new_acc,
                    SUM(CASE WHEN status = 'Active' AND account_opening_date >= ? THEN monthly_amount ELSE 0 END) as new_amt,
                    
                    COUNT(CASE WHEN status = 'Active' THEN 1 END) as status_active,
                    COUNT(CASE WHEN status = 'Hold' THEN 1 END) as status_hold,
                    COUNT(CASE WHEN status = 'Completed' THEN 1 END) as status_completed,
                    COUNT(CASE WHEN status = 'Matured' THEN 1 END) as status_matured,
                    COUNT(CASE WHEN status = 'Pre-Matured' THEN 1 END) as status_prematured
                ", [
                // f_pending (Current Month)
                $startOfMonth,
                $endOfMonth,
                $startOfMonth,
                $endOfMonth,

                // f_paid (Next Month)
                $nextMonthStart,
                $nextMonthEnd,
                $nextMonthStart,
                $nextMonthEnd,

                // s_pending (Current Month)
                $startOfMonth,
                $endOfMonth,
                $startOfMonth,
                $endOfMonth,

                // s_paid (Next Month)
                $nextMonthStart,
                $nextMonthEnd,
                $nextMonthStart,
                $nextMonthEnd,

                // advance_acc & advance_amt (> Next Month End or > Current Month End depending on logic, keeping your reference boundary)
                $nextMonthEnd,
                $nextMonthEnd,

                // new_acc & new_amt
                $startOfMonth,
                $startOfMonth
            ])
            ->first();

        $data =  [
            'totalAccounts' => number_format($data->total_portal_accounts ?? 0),
            'portfolio' => (int)$data->portfolio ?? 0,
            'firstHalf' => [
                'pendingAccount' => (string) ($data->f_pending_acc ?? 0),
                'pendingAmount' => (int)$data->f_pending_amt ?? 0,
                'paidAccount' => (string) ($data->f_paid_acc ?? 0),
                'paidAmount' => (int)$data->f_paid_amt ?? 0,
            ],
            'secondHalf' => [
                'pendingAccount' => (string) ($data->s_pending_acc ?? 0),
                'pendingAmount' => (int)$data->s_pending_amt ?? 0,
                'paidAccount' => (string) ($data->s_paid_acc ?? 0),
                'paidAmount' => (int)$data->s_paid_amt ?? 0,
            ],
            'defaulter' => [
                'account' => (string) ($data->def_acc ?? 0),
                'amount' => (int)$data->def_amt ?? 0,
            ],
            'freeze' => [
                'account' => (string) ($data->freeze_acc ?? 0),
                'amount' => (int)$data->freeze_amt ?? 0,
            ],
            'advancePaid' => [
                'account' => (string) ($data->advance_acc ?? 0),
                'amount' => (int)$data->advance_amt ?? 0,
            ],
            'newAccounts' => [
                'account' => (string) ($data->new_acc ?? 0),
                'amount' => (int)$data->new_amt ?? 0,
            ],
            'statusCounts' => [
                'active' => (string) ($data->status_active ?? 0),
                'hold' => (string) ($data->status_hold ?? 0),
                'completed' => (string) ($data->status_completed ?? 0),
                'matured' => (string) ($data->status_matured ?? 0),
                'preMatured' => (string) ($data->status_prematured ?? 0),
            ],
        ];

        Helper::sendResponse('Dop Dashboard Data', 1, $data);
    }

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
            $accounts = $accountsQuery->paginate(10);
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
