<?php

namespace App\Services;

use App\Models\CompanyAccount;
use App\Models\SavingDenomination;
use App\Models\SavingExpenses;
use App\Models\SavingRm;
use App\Models\SavingRmEntries;
use Illuminate\Support\Facades\DB;

class ReportDashboardService
{
    public function getDashboard($user, $month, $year)
    {
        /* COLLECTION */
        $totalCollection = SavingRmEntries::whereMonth('entry_date', $month)
            ->whereYear('entry_date', $year)
            ->sum('amount');

        $totalCollectionEntries = SavingRmEntries::whereMonth('entry_date', $month)
            ->whereYear('entry_date', $year)
            ->count();

        $totalCustomersEnteries = SavingRmEntries::whereMonth('entry_date', $month)
            ->whereYear('entry_date', $year)
            ->distinct('rm_id')
            ->count('rm_id');

        $totalCustomers = SavingRm::where('company_id', $user->company_id)->count();

        /* DENOMINATION */
        $denominationTotals = SavingDenomination::where('company_id', $user->company_id)
            ->whereMonth('denomination_date', $month)
            ->whereYear('denomination_date', $year)
            ->select(DB::raw("SUM(n_2000*2000 + n_500*500 + n_200*200 + n_100*100 + n_50*50 + n_20*20 + n_10*10) as total_cash,SUM(COALESCE(online,0)) as total_online"))->first();

        $cashReceived = $denominationTotals->total_cash ?? 0;
        $onlineReceived = $denominationTotals->total_online ?? 0;

        /* EXPENSES */
        $cashExpenses = $this->getExpenses($user, $month, $year, 'cash');
        $onlineExpenses = $this->getExpenses($user, $month, $year, 'online');

        $cashExpenseTotal = $cashExpenses->total ?? 0;
        $onlineExpenseTotal = $onlineExpenses->total ?? 0;

        /* WITHDRAWALS */
        $totalWithdrawals = ($cashExpenses->withdrawal ?? 0) + ($onlineExpenses->withdrawal ?? 0);

        /* BALANCES */
        $availableCash = $cashReceived - $cashExpenseTotal;
        $availableOnline = $onlineReceived - $onlineExpenseTotal;

        /* PROFIT */
        $totalReceived = $cashReceived + $onlineReceived;
        $totalExpenses = $cashExpenseTotal + $onlineExpenseTotal;

        $profitLoss = $totalReceived - $totalExpenses;
        $status = $profitLoss >= 0 ? 'profit' : 'loss';

        return [
            'summary' => compact('totalReceived', 'totalExpenses', 'profitLoss', 'status'),

            'cash_summary' => [
                'received' => $cashReceived,
                'available' => $availableCash,
                'expenses' => $cashExpenses,
            ],

            'online_summary' => [
                'received' => $onlineReceived,
                'available' => $availableOnline,
                'expenses' => $onlineExpenses,
            ],

            'withdrawals' => [
                'cash' => $cashExpenses->withdrawal ?? 0,
                'online' => $onlineExpenses->withdrawal ?? 0,
                'total' => $totalWithdrawals,
            ],

            'collection_summary' => compact(
                'totalCollection',
                'totalCollectionEntries',
                'totalCustomers',
                'totalCustomersEnteries'
            ),
        ];
    }

    private function getExpenses($user, $month, $year, $type)
    {
        return SavingExpenses::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('company_id', $user->company_id)
            ->where('amount_type', $type)
            ->select(
                DB::raw("SUM(CASE WHEN expenses_type = 'Others' THEN amount ELSE 0 END) as others"),
                DB::raw("SUM(CASE WHEN expenses_type = 'Lot' THEN amount ELSE 0 END) as rd"),
                DB::raw("SUM(CASE WHEN expenses_type = 'Default' THEN amount ELSE 0 END) as default_amount"),
                DB::raw("SUM(CASE WHEN expenses_type = 'Withdrawal' THEN amount ELSE 0 END) as withdrawal"),
                DB::raw("SUM(CASE WHEN expenses_type != 'Withdrawal' THEN amount ELSE 0 END) as total")
            )->first();
    }
}
