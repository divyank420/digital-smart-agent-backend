<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\SavingRmEntries;
use App\Models\SavingExpenses;
use App\Models\SavingDenomination;
use App\Helper\Helper;
use PDF;

class ReportsController extends Controller
{
    public function getOverAllReport(Request $request){
        $user = Auth::user();
        $date = date('Y-m-d');
        $total['collection'] = SavingRmEntries::whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))->where('company_id',$user->company_id)->sum('amount');
        $total['expenses'] = SavingExpenses::whereMonth('created_at',date('m'))
        ->whereYear('created_at',date('Y'))->where('company_id',$user->company_id)
        ->select(
            DB::raw("sum(case when expenses_type = 'Others' then amount else 0 end) as others"),
            DB::raw("sum(case when expenses_type = 'Lot' then amount else 0 end) as lot"),
            DB::raw("sum(case when expenses_type = 'Default' then amount else 0 end) as default_amount"),
            DB::raw("sum(case when expenses_type = 'Withdrawal' then amount else 0 end) as withdrawal")
            )->first();
        $total['denomination'] = SavingDenomination::whereMonth('denomination_date',date('m'))->whereYear('denomination_date',date('Y'))->where('company_id',$user->company_id)->sum('total');
        sendResponse("All Report Data",1,$total);
    }
    public function yearlyReport(Request $request){
        try {
            $company_id = Auth::user()->company_id;
            $year = (isset($request->year) && !empty($request->year))?$request->year:date('Y');
            $MonthReport = SavingRmEntries::select(
                DB::raw("MONTH(entry_date) month"),
                DB::raw("sum(amount) amount"),
                DB::raw("sum(case when amount_type = 'cash' then amount else 0 end) cash"),
                DB::raw("sum(case when amount_type = 'online' then amount else 0 end) online"),
            )
            ->where('company_id',$company_id)
            ->whereYear('entry_date','=',$year)->groupBy('month')->get()->toArray();
            //dd($MonthReport);
            $MonthReportExpenses = SavingExpenses::select(
                DB::raw("MONTH(created_at) month"),
                DB::raw("sum(amount) amount"),
                DB::raw("sum(case when expenses_type = 'Others' then amount else 0 end) others"),
                DB::raw("sum(case when expenses_type = 'Lot' then amount else 0 end) lot"),
            )
            ->where('company_id',$company_id)
            ->whereYear('created_at','=',$year)
            ->groupBy('month')->get()->toArray();
            $report = [];
            $monthCount = (isset($request->year) && $request->year < date('Y'))?12:date('m');
            for ($i= $monthCount; $i >= 1 ; $i--) {
                $key = array_search($i, array_column($MonthReport,'month'));
                $expKey = array_search($i, array_column($MonthReportExpenses,'month'));
                $monthName = date('F', mktime(0, 0, 0, $i, 10));
                $monthData = ['month_name'=>$monthName,'month'=>$i];
                $monthData['amount'] = $monthData['cash'] = $monthData['online'] = 0;
                $monthData['expenses'] = $monthData['lot'] = $monthData['others'] = 0;
                if($key !== false){
                    $monthData = $MonthReport[$key];
                    $monthData['month_name'] =  $monthName;
                    $monthData['amount'] =  $monthData['amount'];
                    $monthData['cash'] =  number_format($monthData['cash']);
                    $monthData['online'] =  number_format($monthData['online']);
                }
                if($expKey !== false){
                    $expenseMonthData = $MonthReportExpenses[$expKey];
                    $monthData['expenses'] =  $expenseMonthData['amount'];
                    $monthData['lot'] = number_format($expenseMonthData['lot']);
                    $monthData['others'] = number_format($expenseMonthData['others']);
                }
                $report[] = $monthData;
            }
            sendResponse("Months Reporty", 1, $report);
        } catch (\Exception $th) {
            sendResponse($th->getMessage());
        }

    }
    public function MonthlyReport(Request $request){
        // normalize month/year inputs and compute last date of month correctly
        $month = isset($request->month) && !empty($request->month) ? intval($request->month) : intval(date('m'));
        $year = isset($request->year) && !empty($request->year) ? intval($request->year) : intval(date('Y'));
        $current_month = str_pad($month, 2, '0', STR_PAD_LEFT);
        $lastDate = date('t', strtotime($year.'-'.str_pad($month,2,'0',STR_PAD_LEFT).'-01'));

        try {
            $company_id = Auth::user()->company_id;
            $MonthReport = SavingRmEntries::select(
                DB::raw("DAY(entry_date) day"),
                DB::raw("sum(amount) amount"),
                DB::raw("sum(case when amount_type = 'cash' then amount else 0 end) cash"),
                DB::raw("sum(case when amount_type = 'online' then amount else 0 end) online"),
            )
            ->where('company_id',$company_id)
            ->whereYear('entry_date','=',$year)
            ->whereMonth('entry_date','=',$current_month)
            ->groupBy('day')->get()->toArray();
            
            $MonthReportExpenses = SavingExpenses::select(
                DB::raw("DAY(created_at) day"),
                DB::raw("sum(amount) amount"),
                DB::raw("sum(case when expenses_type = 'Others' then amount else 0 end) others"),
                DB::raw("sum(case when expenses_type = 'Lot' then amount else 0 end) lot"),
            )
            ->where('company_id',$company_id)
            ->whereYear('created_at','=',$year)
            ->whereMonth('created_at','=',$current_month)
            ->groupBy('day')->get()->toArray();
            $report = [];
            // if requested month/year is the current month and year, use today's day as end date
            $endDate = ($month == intval(date('m')) && $year == intval(date('Y'))) ? intval(date('d')) : intval($lastDate);
            for ($i = $endDate; $i >= 1 ; $i--) {
                $key = array_search($i, array_column($MonthReport,'day'));
                $expKey = array_search($i, array_column($MonthReportExpenses,'day'));
                // build a proper date label for the day
                $dayLabel = date('d', strtotime($year.'-'.str_pad($month,2,'0',STR_PAD_LEFT).'-'.str_pad($i,2,'0',STR_PAD_LEFT)));
                $monthData = [];
                $monthData['day'] = (int)$i;
                $monthData['amount'] = $monthData['cash'] = $monthData['online'] = 0;
                $monthData['expenses'] = $monthData['lot'] = $monthData['others'] = 0;
                if($key !== false){
                    $data = $MonthReport[$key];
                    $monthData['amount'] =  $data['amount'];
                    $monthData['cash'] =  number_format($data['cash']);
                    $monthData['online'] =  number_format($data['online']);
                }
                if($expKey !== false){
                    $expenseMonthData = $MonthReportExpenses[$expKey];
                    $monthData['expenses'] =  $expenseMonthData['amount'];
                    $monthData['lot'] = number_format($expenseMonthData['lot']);
                    $monthData['others'] = number_format($expenseMonthData['others']);

                }
                $report[] = $monthData;
            }
            sendResponse("Months Reporty", 1, $report);
        } catch (\Exception $e) {
            sendResponse($e->getMessage());
        }
    }
    public function daysCollectionList(){
        $entries = SavingRmEntries::selectRaw('month(entry_date) as month')->whereYear('entry_date','=','2022')->groupBy('month')->get();
        $entries = DB::table('saving_rm_entries')->select(['*'])->get();
    } 

    public function generatePdfReport(Request $request){
        if(isset($request->company_id) && !empty($request->date)){
            $requestDate = date('Y-m-d',strtotime($request->date));
            $company_id = $request->company_id;
            $entries = SavingRmEntries::with('RmDetail','company')->whereDate('entry_date',$requestDate)->get()->map->formatData();
            $company = Helper::getCompanyDetail($company_id);
            $denomination = Helper::getDenomination($company_id,$requestDate);
            $expenses = Helper::getReportExpenses($company_id,$requestDate);
            $pdf = PDF::loadView('pdf.GenerateReport', ['entries'=>$entries,'denomination'=>$denomination,'company'=>$company,'report_date'=>date('d M, Y',strtotime($requestDate)),'expenses'=>$expenses])->setPaper('a4');
            
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();
            
            $opacity = 0.1;
            //$canvas->set_opacity($opacity, "Multiply");
            //$canvas->page_text($width / 5, $height / 2, 'Watermark Text', null, 55, array(0, 0, 0), 0, 0, 0);

            /* $canvas->set_opacity(.02,"Multiply");
            $canvas->page_text($width/5, $height/2, 'Digital Smart Agent', null,55, array(0,0,0),2,2,-30); */
            return $pdf->download('CR_'.$requestDate.'_'.time().'.pdf');
            return $pdf->stream();
            dd($canvas);
        }else{
            sendResponse();
        }
    }
    
}
