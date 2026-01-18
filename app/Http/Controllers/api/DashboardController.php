<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\SavingExpenses;
use App\Models\SavingRm;
use App\Models\SavingRmEntries;
use App\Models\SavingDenomination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helper\Helper;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        try {
            $user = Auth::user();
            $dashboardData = [];
            $dashboardData['total_rm'] = SavingRm::where('company_id', $user->company_id)->count();
            $dashboardData['today_collection'] = SavingRmEntries::whereDate('created_at', date('Y-m-d'))->where('company_id', $user->company_id)->sum('amount');
            $dashboardData['yesterday_collection'] = SavingRmEntries::whereDate('created_at', date('Y-m-d', strtotime("-1 days")))->where('company_id', $user->company_id)->sum('amount');
            $dashboardData['today_entry_count'] = SavingRmEntries::whereDate('created_at', date('Y-m-d'))->where('company_id', $user->company_id)->count();
            $dashboardData['current_month']['income'] = SavingRmEntries::whereMonth('entry_date', date('m'))->whereYear('entry_date', date('Y'))->where('company_id', $user->company_id)->sum('amount');
            $dashboardData['current_month']['expenses'] = SavingExpenses::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->where('company_id', $user->company_id)->sum('amount');
            $dashboardData['total_rd_lot'] = SavingExpenses::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->where('company_id', $user->company_id)->where('expenses_type', 'Lot')->sum('amount');
            $dashboardData['total_denomination'] = SavingDenomination::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->where('company_id', $user->company_id)->sum('total');

            $dashboardData['expected_collection'] = SavingRm::where('company_id', $user->company_id)
                ->where('status', 1)
                ->sum('monthly_amount');

            $dashboardData['received_collection'] = SavingRmEntries::whereMonth('entry_date', date('m'))
                ->whereYear('entry_date', date('Y'))
                ->where('company_id', $user->company_id)
                ->sum('amount');

            $dashboardData['remaining_collection'] =
                $dashboardData['expected_collection'] - $dashboardData['received_collection'];

            $monthlyPaidRms = SavingRmEntries::select(
                'rm_id',
                DB::raw('SUM(amount) as total_paid')
            )
                ->whereMonth('entry_date', date('m'))
                ->whereYear('entry_date', date('Y'))
                ->where('company_id', $user->company_id)
                ->groupBy('rm_id')
                ->pluck('total_paid', 'rm_id');

            $fullyPaidRmCount = SavingRm::where('company_id', $user->company_id)
                ->whereIn('id', $monthlyPaidRms->keys())
                ->get()
                ->filter(function ($rm) use ($monthlyPaidRms) {
                    return ($monthlyPaidRms[$rm->id] ?? 0) >= $rm->monthly_amount;
                })
                ->count();
            $dashboardData['total_rms'] = SavingRm::where('company_id', $user->company_id)->count();

            $dashboardData['fully_paid_rms'] = $fullyPaidRmCount;

            $dashboardData['remaining_rms'] =
                $dashboardData['total_rms'] - $dashboardData['fully_paid_rms'];


            for ($i = 0; $i < 12; $i++) {
                $date = ($i == 0) ? date('Y-m-d') : date('Y-m-d', strtotime('-' . $i . ' day'));

                $collection = SavingRmEntries::whereDate('entry_date', $date)
                    ->where('company_id', $user->company_id)
                    ->selectRaw("
                        SUM(CASE WHEN amount_type = 'online' THEN amount ELSE 0 END) as online,
                        SUM(CASE WHEN amount_type = 'cash' THEN amount ELSE 0 END) as cash,
                        SUM(amount) as total
                    ")
                    ->first();

                $expense = SavingExpenses::whereDate('created_at', $date)->where('expenses_type', 'Others')->where('company_id', $user->company_id)->sum('amount');

                $denomination = SavingDenomination::whereDate('denomination_date', $date)->where('company_id', $user->company_id)->sum('total');

                $total_deno_exp_amount = $denomination + $expense;
                $dashboardData['last_records_history'][] = [
                    'date'        => date('d-M', strtotime($date)),
                    'online'      => $collection->online ?? 0,
                    'cash'        => $collection->cash ?? 0,
                    'collection'  => $collection->total ?? 0,
                    'expenses'    => $expense ?? 0,
                    'denomination' => $denomination ?? 0,
                    'total_deno'  => $total_deno_exp_amount
                ];
            }

            Helper::sendResponse("Dashboard Data", 1, $dashboardData);
        } catch (\Throwable $th) {
            Helper::sendResponse($th->getMessage());
        }
    }

    public function getDashboardSummary(Request $request)
    {
        $user = Auth::user();

        $month = $request->month ?? date('m');
        $year  = $request->year ?? date('Y');
        $lastDate = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $summaryData = [];

        //for ($i = 0; $i < $lastDate; $i++) {
        for ($i = 0; $i <= 30; $i++) {

            $date = sprintf('%04d-%02d-%02d', $year, $month, $i);
            $date = ($i == 0) ? date('Y-m-d') : date('Y-m-d', strtotime('-' . $i . ' day'));

            $collection = SavingRmEntries::whereDate('entry_date', $date)
                ->where('company_id', $user->company_id)
                ->selectRaw("
                SUM(CASE WHEN amount_type = 'online' THEN amount ELSE 0 END) as online,
                SUM(CASE WHEN amount_type = 'cash' THEN amount ELSE 0 END) as cash,
                SUM(amount) as total
            ")
                ->first();

            $expense = SavingExpenses::whereDate('created_at', $date)
                ->where('expenses_type', 'Others')
                ->where('company_id', $user->company_id)
                ->sum('amount');

            $denomination = SavingDenomination::whereDate('denomination_date', $date)
                ->where('company_id', $user->company_id)
                ->sum('total');

            $summaryData[] = [
                'date'          => date('d-M', strtotime($date)),
                'online'        => $collection->online ?? 0,
                'cash'          => $collection->cash ?? 0,
                'collection'    => $collection->total ?? 0,
                'expenses'      => $expense ?? 0,
                'denomination'  => $denomination ?? 0,
                'total_deno'    => ($denomination + $expense),
            ];
        }

        return Helper::sendResponse(
            "Dashboard summary data",
            1,
            [
                'month' => $month,
                'year'  => $year,
                'data'  => $summaryData
            ]
        );
    }
}
