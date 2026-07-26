<?php

namespace App\Http\Controllers\api;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\DopAccount;
use App\Models\DopLot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DopController extends Controller
{
    public function getDopAccounts(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'dop_agent_id'               => 'required',
        ], ['dop_agent_id.required' => 'Dop Agent Not Selected']);
        if ($validator->fails()) {
            return Helper::sendResponse(Helper::ValidationSet($validator->errors()), 422);
        }
        // Decode filter safely, defaulting to an empty array if null/invalid
        $filter = json_decode($request->filter, true) ?? [];

        $accounts = DopAccount::where('agent_id', $request->dop_agent_id)
            ->when(data_get($filter, 'drodownFilter') === 'defaulter', function ($query) use ($request) {
                $query->where('user_id', $request->id);
            })
            ->when(data_get($filter, 'search'), function ($query) use ($filter) {
                $searchTerm = $filter['search'];
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('account_name', 'like', "%{$searchTerm}%")
                        ->orWhere('short_code', $searchTerm)
                        ->orWhere('account_no', $searchTerm);
                });
            })
            ->when(data_get($filter, 'drodownFilter') === 'defaulter', function ($query) {
                $query->where('defaulter_installment', '>', 0);
            })
            ->when(data_get($filter, 'drodownFilter') === 'newly-added', function ($query) {
                $query->whereBetween('account_opening_date', [
                    Carbon::now()->subMonths(3)->startOfMonth(),
                    Carbon::now()->endOfMonth(),
                ]);
            })
            ->when(data_get($filter, 'drodownFilter') === 'near-to-maturity', function ($query) {
                $query->whereBetween('maturity_date', [
                    today(),
                    today()->addMonths(3)
                ])->where('status', 'active');
            });

        if ($request->type == 'list') {
            $accounts = $accounts->select('id', 'agent_id', 'account_no', 'account_name', 'monthly_amount', 'short_code', 'defaulter_installment');
            $data['accounts'] = $accounts->get()->keyBy('account_no');
            $data['accounts_by_short_code'] = $accounts->get()->keyBy('short_code')->toArray();
            return Helper::sendResponse('Accounts List', 1, $data);
        } else {
            $accounts = $accounts->get();
            return Helper::sendResponse('Accounts List', 1, $accounts);
        }
    }

    public function lots(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'dop_agent_id'               => 'required',
        ], ['dop_agent_id.required' => 'Dop Agent Not Selected']);
        
        if ($validator->fails()) {
            return Helper::sendResponse(Helper::ValidationSet($validator->errors()), 422);
        }
        $lots = DopLot::with('items')
            ->where('agent_id', $request->dop_agent_id)
            ->when($request->status !== 'all', function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->get();
        return Helper::sendResponse('Lots Listing', 1, $lots);
    }
}
