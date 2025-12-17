<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SavingDenomination;
use App\Helper\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DenominationController extends Controller
{
    public function index(Request $request){
        $agentId = $request->agent??'';
        if($request->ajax()){
            if(isset($request->agent) && !empty($request->agent)){
                $user_id = $request->agent;
            }
        }
        $loggedInUserId = (auth()->user()->id == $agentId)?true:false;

        $month = isset($request->month)?$request->month:date('m');
        $year = isset($request->year)?$request->year:date('Y');
        $strDate = $year.'-'.$month.'-'.'01';
        $start_date = date('Y-m-01',strtotime($strDate));
        $end_date = date('Y-m-t',strtotime($strDate));
        $denomination = SavingDenomination::select([
            'id',
            'user_id',
            'denomination_date',
            DB::raw('SUM(CASE WHEN online > 0 THEN online ELSE 0 END) as online'),
            DB::raw('SUM(CASE WHEN n_2000 > 0 THEN n_2000 ELSE 0 END) as n_2000'),
            DB::raw('SUM(CASE WHEN n_2000 > 0 THEN n_2000*2000 ELSE 0 END) as n_2000_value'),
            DB::raw('SUM(CASE WHEN n_500 > 0 THEN n_500 ELSE 0 END) as n_500'),
            DB::raw('SUM(CASE WHEN n_500 > 0 THEN n_500*500 ELSE 0 END) as n_500_value'),
            DB::raw('SUM(CASE WHEN n_200 > 0 THEN n_200 ELSE 0 END) as n_200'),
            DB::raw('SUM(CASE WHEN n_200 > 0 THEN n_200*200 ELSE 0 END) as n_200_value'),
            DB::raw('SUM(CASE WHEN n_100 > 0 THEN n_100 ELSE 0 END) as n_100'),
            DB::raw('SUM(CASE WHEN n_100 > 0 THEN n_100*100 ELSE 0 END) as n_100_value'),
            DB::raw('SUM(CASE WHEN n_50 > 0 THEN n_50 ELSE 0 END) as n_50'),
            DB::raw('SUM(CASE WHEN n_50 > 0 THEN n_50*50 ELSE 0 END) as n_50_value'),
            DB::raw('SUM(CASE WHEN n_20 > 0 THEN n_20 ELSE 0 END) as n_20'),
            DB::raw('SUM(CASE WHEN n_20 > 0 THEN n_20*20 ELSE 0 END) as n_20_value'),
            DB::raw('SUM(CASE WHEN n_10 > 0 THEN n_10 ELSE 0 END) as n_10'),
            DB::raw('SUM(CASE WHEN n_10 > 0 THEN n_10*10 ELSE 0 END) as n_10_value'),
        ])->company()
        //->whereDate('denomination_date','>=',$start_date)->whereDate('denomination_date','<=',$end_date);
        ->whereYear('denomination_date',$year)->whereMonth('denomination_date',$month);
        
        if(isset($user_id)){
            $denomination = $denomination->where('user_id',$user_id);
        }
        $denomination = $denomination
        ->groupBy('denomination_date')
        ->orderBy('denomination_date','DESC')->paginate(15);
        if($request->ajax()){
            $list = view('agents.denomination.list',compact('denomination','loggedInUserId'))->render();
            return response()->json(['status'=>1,'data'=>$list], 200);
        }
        return view('agents.denomination.index',compact('denomination'));
    }
    public function editDenomination(Request $request,$id){
        $denomination = SavingDenomination::company()->where('id',$id)->first();
        if($request->isMethod('POST')){

            $denomination->fill($request->all());
            $denomination->denomination_date = $request->denomination_date != null ?date('Y-m-d',strtotime($request->denomination_date)):$denomination->denomination_date;
            $denomination->save();
            $request->session()->flash('success', 'Denomination successfully updated');
            return redirect()->route('agent.denominationList');
        }
        return view('agents.denomination.edit',compact('denomination','id'));
    }

    public function newDenomination(Request $request){
        if($request->isMethod('POST')){
            $user = auth()->user();
            $denomination_date = $request->denomination_date != null ?date('Y-m-d',strtotime($request->denomination_date)):date('Y-m-d');
            $denomination = SavingDenomination::company()->where('user_id',$user->id)->whereDate('denomination_date',$denomination_date)->first();
            if(empty($denomination)){
                $denomination = new SavingDenomination();
                $denomination->fill($request->all());
                $denomination->user_id = $user->id;
                $denomination->company_id = $user->company_id;
                $denomination->denomination_date = $denomination_date;
                $denomination->save();
                $request->session()->flash('success', 'Denomination successfully uploaded');
            }else{
                $request->session()->flash('error', 'Denomination already exist, please update or delete that');
            }
            return redirect()->route('agent.denominationList');
        }
        return view('agents.denomination.add');
    }
    public function getDenominationList(){
        //$user_id = auth()->user()->id;
        //$denomination = SavingDenomination::where('agent_id',$user_id)->orderBy('id','DESC')->take(7)->get();
        $denomination = SavingDenomination::orderBy('id','DESC')->take(7)->get();
        if($denomination->count() > 0){
            Helper::sendResponse("Denomiantion List", 1,$denomination);
        }else{
            Helper::sendResponse("something went wrong");
        }
    }
}
