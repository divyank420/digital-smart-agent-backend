<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SavingRm;
use App\Models\SavingRmEntries;
use App\Models\SavingExpenses;
use App\Models\SavingDenomination;
use Illuminate\Support\Facades\Auth;

class AgentDashboardController extends Controller
{
    public function index(Request $request){
            $user = Auth::user();
            $dashboardData = [];
            $dashboardData['total_rm'] = SavingRm::where('company_id',$user->company_id)->count();
            $dashboardData['today_collection'] = SavingRmEntries::whereDate('created_at',date('Y-m-d'))->where('company_id',$user->company_id)->sum('amount');
            $dashboardData['yesterday_collection'] = SavingRmEntries::whereDate('created_at',date('Y-m-d',strtotime("-1 days")))->where('company_id',$user->company_id)->sum('amount');
            $dashboardData['today_entry_count'] = SavingRmEntries::whereDate('created_at',date('Y-m-d'))->where('company_id',$user->company_id)->count();
            $dashboardData['total_collection'] = SavingRmEntries::whereMonth('entry_date',date('m'))->whereYear('entry_date',date('Y'))->where('company_id',$user->company_id)->sum('amount');
            $dashboardData['total_expenses'] = SavingExpenses::whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))->where('expenses_type','Others')->where('company_id',$user->company_id)->sum('amount');
            $dashboardData['total_rd_lot'] = SavingExpenses::whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))->where('company_id',$user->company_id)->where('expenses_type','Lot')->sum('amount');
            $dashboardData['total_denomination'] = SavingDenomination::whereMonth('denomination_date',date('m'))->whereYear('denomination_date',date('Y'))->where('company_id',$user->company_id)->sum('total');
            $dashboardData['pieChart'] = json_encode([(int)$dashboardData['total_rd_lot'],(int)$dashboardData['total_denomination'],(int)$dashboardData['total_collection'],(int)$dashboardData['total_expenses']]);
        return view('agents.dashboard.index',compact('dashboardData'));
    }
}
