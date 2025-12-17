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
        $accounts_total = SavingRmEntries::with('RmDetail')->select([
            'rm_id',
            DB::raw('SUM(amount) as account_total'),
        ])->whereIn('rm_id',$rms_accounts)->groupBy('rm_id')->get();
        return Helper::sendResponse("Dashboard Data",1,$accounts_total);
    }
    public function portfolio(Request $request){
        $rms = SavingRm::where('customer_id',$this->user->id)->get();
        dd($rms);
    }
}
