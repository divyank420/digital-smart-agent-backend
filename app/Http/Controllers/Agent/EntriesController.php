<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SavingRmEntries;

class EntriesController extends Controller
{
    public function index(Request $request){
        //$entries = SavingRmEntries::whereDate('entry_date',date('Y-m-d'))->get();

        $rowCount  = 20;
        $filter = ['search'=>$request->search??"",'date'=>$request->date??date('Y-m-d')];
        $entries = SavingRmEntries::with('agent','RmDetail');
        if(!empty($filter['search'])){
            $entries = $entries->whereHas('RmDetail',function($q) use ($request){
                return $q->where('name','LIKE',"%$request->search%");
            });
        }
        if(!empty($request->agent)){
            $entries = $entries->where('user_id',$request->agent);
        }
        if(!empty($request->amount_type)){
            $entries = $entries->where('amount_type',$request->amount_type);
        }

        $entries = $entries->whereDate('entry_date',$filter['date'])->orderBy('id','DESC')->paginate($rowCount);
        if($request->ajax()){
            $list =  view('agents.entries.list', compact('entries'))->render();
            return response()->json(['status'=>1,'data'=>$list], 200);
        }
        return view('agents.entries.index', compact('entries'));
    }
}
