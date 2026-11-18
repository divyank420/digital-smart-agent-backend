<?php

namespace App\Http\Controllers\api\Customer;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\SavingRm;
use App\Models\SavingRmEntries;
use App\Services\RmPaymentSummaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomersController extends Controller
{

    public $user;

    public function __construct()
    {
        $this->user = Auth::guard('customer')->user();
    }

    public function dashboard(Request $request)
    {
        $rms_accounts = SavingRm::where('customer_id', $this->user->id)->pluck('id');
        //Helper::pushNotification($this->user,'Hello',"tetse");
        $accounts_total = SavingRmEntries::with(['RmDetail:id,name,rm_code,monthly_amount,installment_amount'])->select([
            'rm_id',
            DB::raw('SUM(amount) as account_total'),
        ])->whereIn('rm_id', $rms_accounts)->groupBy('rm_id')->get();
        $recent_entries = SavingRmEntries::with('RmDetail:id,name')->whereIn('rm_id', $rms_accounts)->limit(5)->latest()->get();
        $data = [
            'accounts_total' => $accounts_total,
            'recent_entries' => $recent_entries,
        ];

        return Helper::sendResponse("Dashboard Data", 1, $data);
    }

    public function getRmAccounts(Request $request)
    {
        $rms = SavingRm::where('customer_id', $request->customer_key);
        if (isset($request->search) && !empty($request->search)) {
            $rms = $rms->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $rms = $rms->get();
        $summaries = app(RmPaymentSummaryService::class)
            ->getSummary($rms->pluck('id')->toArray(), true);
        $data = $rms->map(function ($rm) use ($summaries) {
            $arr = [
                'id' => $rm->id,
                'rm_code' => $rm->rm_code,
                'name' => $rm->name,
                'account_type' => $rm->account_type,
                'monthly_amount' => $rm->monthly_amount,
                'installment_amount' => $rm->monthly_amount,
                'opening_month' => $rm->opening_month,
                'opening_year' => $rm->opening_year,
                'opening_balance' => $rm->opening_balance,
            ];
            return array_merge($arr, $summaries[$rm->id] ?? []);
        });

        Helper::sendResponse('Rm Accounts', 1, $data);
    }
}
