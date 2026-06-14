<?php

namespace App\Http\Controllers\api;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SavingRm;
use App\Models\SavingRmEntries;
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
        $total_deposit = SavingRmEntries::with(['RmDetail:id,name,rm_code,monthly_amount,installment_amount'])->select([
            DB::raw('SUM(amount) as total_deposit'),
        ])->whereIn('rm_id', $rms_accounts)->groupBy('rm_id')->pluck('total_deposit')->first();

        $dashboardData = [
            'rm_accounts' => count($rms_accounts),
            'total_deposit' => $total_deposit,
        ];

        return Helper::sendResponse("Dashboard Data", 1, $dashboardData);
    }

    public function yearlyReportSummary(Request $request)
    {
        $year = $request->year ?? date('Y');
        $entries = SavingRmEntries::select('payment_month', DB::raw("sum(amount) amount"),)->where('rm_id', 100)->where('payment_year', $year)->groupBy('payment_month')->get();
        return Helper::sendResponse("Yearly Report", 1, $entries);
    }
    public function monthlyReports(Request $request)
    {
        $entries = SavingRmEntries::select('entry_date', DB::raw("sum(amount) amount"),)->where('rm_id', 100)->where(['payment_year' => 2025, 'payment_month' => 02])->get();
        return Helper::sendResponse("Yearly Report", 1, $entries);
    }
}
