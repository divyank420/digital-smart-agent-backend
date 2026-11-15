<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SavingRm;
use App\Models\Entries;
use App\Models\SavingRmEntries;
use App\Exports\MonthlyPostingReportExport;
use App\Helper\Helper;
use App\Models\SavingCompany;
use App\Models\SavingDenomination;
use App\Models\SavingExpenses;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PdfReportController extends Controller
{
    public function getCustomerInstallmentReport(Request $request)
    {
        $rm = SavingRm::where('id', 1)->first();
        $startDate = date('Y-m-01', strtotime('-1 month'));
        $endDate = date('Y-m-d');
        $company = Helper::getCompanyDetail(1);
        $entries = SavingRmEntries::where('rm_id', 33)->where('entry_date', '>', $startDate)->where('entry_date', '<', $endDate)->get()->toArray();
        $pdf = Pdf::loadView('pdf.CustomerEntriesReport', ['start_date' => $startDate, 'end_date' => $endDate, 'company' => $company]);
        $pdf->stream();
        dd($entries);
        dd($entries);
    }

    public function monthlyPostingReport(Request $request)
    {

        if (isset($request->company_id)) {
            if (isset($request->date) && !empty($request->date)) {
                $requestDate = date('Y-m-d', strtotime($request->date));
            } else {
                $requestDate = date('Y-m-d');
            }

            $account_type = (isset($request->account_type) && !empty($request->account_type)) ? $request->account_type : 'daily';
            $year = date('Y', strtotime($requestDate));
            $month = date('m', strtotime($requestDate));
            $endDate = (date('m') == $month && date('Y') == $year) ? date('d') : date('t', strtotime($requestDate));
            $company_id = $request->company_id;

            /* $rms = SavingRm::whereHas('entries',function($q){
                $q->whereMonth('entry_date','10')->whereYear('entry_date','2023');
            })->where('account_type','daily')->limit(5)->get(); */

            //$rms = SavingRm::where('account_type',$account_type)->orderBy('name','ASC')->limit(80)->get();
            $rms = SavingRm::where('account_type', $account_type)->orderBy('name', 'ASC')->get();
            $reportData = [];
            $dateData = ['year' => $year, 'endDate' => $endDate, 'month' => $month];
            foreach ($rms as $key => $value) {
                $rm_id = $value->id;
                $indexData = ['name' => $value->name, 'monthly_amount' => $value->monthly_amount, 'is_complete' => 'bg-danger'];
                $entries = SavingRmEntries::where('rm_id', $value->id)->whereMonth('entry_date', $month)->whereYear('entry_date', $year)->get()->toArray();
                $totalAmount = 0;
                for ($i = 1; $i <= $endDate; $i++) {
                    $searchDate = trim(date("Y-m-d", strtotime("$year-$month-$i")));
                    $entriesDate = array_column($entries, 'entry_date');
                    $index = array_search($searchDate, array_column($entries, 'entry_date'));
                    if ($index !== false) {
                        $totalAmount += $entries[$index]['amount'];
                        $indexData['monthly_data'][$i] = ['amount' => $entries[$index]['amount'], 'amount_type' => $entries[$index]['amount_type']];
                    } else {
                        $indexData['monthly_data'][$i] = ['amount' => 0, 'amount_type' => '-'];
                    }
                }
                $indexData['is_installment_complete'] = ($totalAmount < $value->monthly_amount) ? 'danger' : 'success';
                $indexData['paid_installment_amount'] = $totalAmount;
                $reportData[] = $indexData;
            }

            $company = Helper::getCompanyDetail($company_id);

            $pdf = PDF::loadView('pdf.MonthlyPostingReport', ['dateData' => $dateData, 'rms' => $reportData, 'company' => $company, 'posting_month' => date('M, Y', strtotime($requestDate))])->setPaper('a4', 'landscape');
            //return $pdf->stream();
            return $pdf->download('PR_' . date('M, Y', strtotime($requestDate)) . '_' . time() . '.pdf');
        } else {
            Helper::sendResponse();
        }
    }

    public function rmMonthsDepositsReport(Request $request)
    {
        $requestData = (object)$request->all();
        $monthsArray = explode(',', $requestData->months);
        $monthNames = collect($monthsArray)->map(function ($month) {
            return \Carbon\Carbon::create()->month((int)$month)->format('F');
        })->toArray();
        $rm = SavingRm::where('id', $requestData->key)->first();
        $company = Helper::getCompanyDetail($rm->company_id);
        $report_period = count($monthNames) > 1
            ? $monthNames[0] . ' to ' . end($monthNames) . ' ' . $request->year
            : $monthNames[0] . ' ' . $request->year;

        $entries = SavingRmEntries::with('agent')->where('rm_id', $requestData->key)
            ->whereIn('payment_month', $monthsArray)
            ->where('payment_year', $requestData->year)
            ->get();
        $groupedEntries = $entries->groupBy('payment_month');


        $pdf = Pdf::loadView('pdf.RmMonthsReport', ['groupedEntries' => $groupedEntries, 'report_period' => $report_period, 'company' => $company, 'year' => $requestData->year, 'rm' => $rm]);
        $filename = $rm->name
            . '_'
            . $monthNames[0] . '-' . end($monthNames)
            . '_'
            . $requestData->year
            . '_DPT_RPT_'
            . time()
            . '.pdf';
        return $pdf->stream($filename);
        return $pdf->download($filename);
        //dd($request->all(), $groupedEntries);
    }

    public function rmCurrentMonthDepositReport(Request $request)
    {
        $rm = SavingRm::where('id', $request->key)->first();
        $company = Helper::getCompanyDetail($rm->company_id);
        $entries = SavingRmEntries::with('agent')->where('rm_id', $request->key)
            ->where('payment_month', $request->month)
            ->where('payment_year', $request->year)
            ->get();
        $report_period = date('M Y', strtotime($request->year . '-' . $request->month . '-1'));
        $pdf = Pdf::loadView('pdf.RmCurrentMonthReport', ['entries' => $entries, 'report_period' => $report_period, 'company' => $company, 'rm' => $rm]);
        $filename = $rm->name
            . '_'
            . $report_period
            . time()
            . '.pdf';
        return $pdf->stream($filename);
    }

    public function todaysReport()
    {
        $companyId = Auth::user()->company_id ?? 1;
        $company = SavingCompany::where('id', $companyId)->first();
        $date = date('Y-m-d');
        $collectionData = SavingRmEntries::with('RmDetail', 'agent')
            ->where('company_id', $companyId)
            ->whereDate('entry_date', $date)
            ->get();


        $denominations = SavingDenomination::select([
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
        ])->with(['agent'])
            ->where('company_id', $companyId)
            ->whereDate('denomination_date', $date)
            ->groupBy('user_id')
            ->get();

        $expenseData = SavingExpenses::where('company_id', $companyId)
            ->whereDate('expenses_date', $date)
            ->get();
        $totalCollection = $collectionData->sum('amount');
        $totalExpenses = $expenseData->sum('amount');
        $data = [
            'date' => $date,
            'company' => $company,
            'denominations' => $denominations,
            'collectionData' => $collectionData,
            'totalCollection' => $totalCollection,
            'expenseData' => $expenseData,
            'totalExpenses' => $totalExpenses,
        ];
        $pdf = Pdf::loadView('pdf.daily-report', $data);
        $now = time();

        $filename = "CR-{$date}-{$now}.pdf";
        return $pdf->stream($filename);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, "CR-{$date}-{$now}.pdf", [
            'Content-Type' => 'application/pdf',
        ]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, "CR-{$date}-{$now}.pdf");
    }
}
