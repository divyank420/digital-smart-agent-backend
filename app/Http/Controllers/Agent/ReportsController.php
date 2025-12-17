<?php

namespace App\Http\Controllers\Agent;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SavingRmEntries;

class ReportsController extends Controller
{
    public function CollectionReport(Request $request){
        //dd($request->all());
        $company_id = auth()->user()->company_id;
        $requestDate = isset($request->date)?date('Y-m-d',strtotime($request->date)):date('Y-m-d');
        $entries = SavingRmEntries::with('RmDetail','company')->whereDate('entry_date',$requestDate)->get()->map->formatData();
        $denomination = Helper::getDenomination($company_id,$requestDate);
        $expenses = Helper::getReportExpenses($company_id,$requestDate);
        $data = ['entries'=>$entries,'denomination'=>$denomination,'expenses'=>$expenses];
        if($request->ajax()){
            $html = view('agents.reports.collection_reports_filter_view', compact('data'))->render();
            return response()->json(['status'=>1,'data'=>$html], 200);
        }
        return view('agents.reports.collection_reports', compact('data'));

    }
    
    public function MonthlyReport(){

    }
}
