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

    public function __construct(){
        $this->user = Auth::guard('customer')->user();
    }

    public function dashboard(Request $request){

        $rms_accounts = SavingRm::where('customer_id',$this->user->id)->pluck('id');
        $accounts_total = SavingRmEntries::with(['RmDetail:id,name,rm_code,monthly_amount,installment_amount'])->select([
            'rm_id',
            DB::raw('SUM(amount) as account_total'),
        ])->whereIn('rm_id',$rms_accounts)->groupBy('rm_id')->get();
        

        return Helper::sendResponse("Dashboard Data",1,$accounts_total);
    }
    public function portfolio(Request $request){
        $rms = SavingRm::where('customer_id',$this->user->id)->get();
        dd($rms);
    }

    public function yearlyReportSummary(Request $request){
        $year = $request->year??date('Y');
        $entries = SavingRmEntries::select('payment_month',DB::raw("sum(amount) amount"),)->where('rm_id',100)->where('payment_year',$year)->groupBy('payment_month')->get();
        return Helper::sendResponse("Yearly Report",1,$entries);
    }
    public function monthlyReports(Request $request){
        $entries = SavingRmEntries::select('entry_date',DB::raw("sum(amount) amount"),)->where('rm_id',100)->where(['payment_year'=>2025,'payment_month'=>02])->get();
        return Helper::sendResponse("Yearly Report",1,$entries);
    }
}
