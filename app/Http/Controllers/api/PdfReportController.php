<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SavingRm;
use App\Models\Entries;
use App\Models\SavingRmEntries;
use App\Exports\MonthlyPostingReportExport;
use App\Helper\Helper;
use Barryvdh\DomPDF\Facade\Pdf;
use Excel;

class PdfReportController extends Controller
{
    public function getCustomerInstallmentReport(Request $request){
        $rm = SavingRm::where('id',1)->first();
        $startDate = date('Y-m-01',strtotime('-1 month'));
        $endDate = date('Y-m-d');
        $company = Helper::getCompanyDetail(1);
        $entries = SavingRmEntries::where('rm_id',33)->where('entry_date','>',$startDate)->where('entry_date','<',$endDate)->get()->toArray();
        $pdf = Pdf::loadView('pdf.CustomerEntriesReport',['start_date'=>$startDate,'end_date'=>$endDate,'company'=>$company]);
        $pdf->stream();
        dd($entries);
        dd($entries);
    }

    public function monthlyPostingReport(Request $request){

        if(isset($request->company_id)){
            if(isset($request->date) && !empty($request->date)){
                $requestDate = date('Y-m-d',strtotime($request->date));
            }else{
                $requestDate = date('Y-m-d');
            }

            $account_type = (isset($request->account_type) && !empty($request->account_type))?$request->account_type:'daily';
            $year = date('Y',strtotime($requestDate));
            $month = date('m',strtotime($requestDate));;
            $endDate = (date('m') == $month && date('Y') == $year)?date('d'):date('t',strtotime($requestDate));
            $company_id = $request->company_id;
            
            /* $rms = SavingRm::whereHas('entries',function($q){
                $q->whereMonth('entry_date','10')->whereYear('entry_date','2023');
            })->where('account_type','daily')->limit(5)->get(); */

            //$rms = SavingRm::where('account_type',$account_type)->orderBy('name','ASC')->limit(80)->get();
            $rms = SavingRm::where('account_type',$account_type)->orderBy('name','ASC')->get();
            $reportData = [];
            $dateData = ['year'=>$year,'endDate'=>$endDate,'month' => $month];
            foreach ($rms as $key => $value) {
                $rm_id = $value->id;
                $indexData = ['name'=>$value->name,'monthly_amount'=>$value->monthly_amount,'is_complete'=>'bg-danger'];
                $entries = SavingRmEntries::where('rm_id',$value->id)->whereMonth('entry_date',$month)->whereYear('entry_date',$year)->get()->toArray();
                $totalAmount = 0;
                for ($i = 1; $i <= $endDate; $i++) {
                    $searchDate = trim(date("Y-m-d", strtotime("$year-$month-$i")));
                    $entriesDate = array_column($entries, 'entry_date');
                    $index = array_search($searchDate,array_column($entries, 'entry_date'));
                    if($index !== false){
                        $totalAmount += $entries[$index]['amount'];
                        $indexData['monthly_data'][$i] = ['amount'=>$entries[$index]['amount'],'amount_type'=>$entries[$index]['amount_type']];
                    }else{
                        $indexData['monthly_data'][$i] = ['amount'=>0,'amount_type'=>'-'];
                    }
                }
                $indexData['is_installment_complete'] = ($totalAmount < $value->monthly_amount)?'danger':'success'; 
                $indexData['paid_installment_amount'] = $totalAmount; 
                $reportData[] = $indexData;
            }
            
            $company = Helper::getCompanyDetail($company_id);
            
            $pdf = PDF::loadView('pdf.MonthlyPostingReport',['dateData'=>$dateData,'rms'=>$reportData,'company'=>$company,'posting_month'=>date('M, Y',strtotime($requestDate))])->setPaper('a4', 'landscape');
            //return $pdf->stream();
            return $pdf->download('PR_'.date('M, Y',strtotime($requestDate)).'_'.time().'.pdf');
        }else{
            Helper::sendResponse();
        }
    }
}
