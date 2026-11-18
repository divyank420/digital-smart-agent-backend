<?php

namespace App\Services;

use App\Helper\Helper;
use App\Models\SavingRm;
use App\Models\SavingRmEntries;
use Illuminate\Support\Facades\DB;

class RmPaymentSummaryService
{
    public function getSummary($rmIds, $isLastEntry = false)
    {
        if (!is_array($rmIds)) {
            $result = $this->getBulkSummary([$rmIds], $isLastEntry);

            return $result[$rmIds] ?? [];
        }

        return $this->getBulkSummary($rmIds, $isLastEntry);
    }

    private function getBulkSummary(array $rmIds, $isLastEntry): array
    {
        $now = now();

        $currentMonth = (int)$now->month;
        $currentYear  = (int)$now->year;

        $lastMonth = (int)$now->copy()->subMonth()->month;
        $lastYear  = (int)$now->copy()->subMonth()->year;

        $nextMonth = (int)$now->copy()->addMonth()->month;
        $nextYear  = (int)$now->copy()->addMonth()->year;

        $rms = SavingRm::whereIn('id', $rmIds)
            ->get()
            ->keyBy('id');

        $entries = SavingRmEntries::whereIn('rm_id', $rmIds)
            ->select(
                'rm_id',
                DB::raw('SUM(amount) as total_deposit'),
                DB::raw("
                    SUM(
                        CASE
                            WHEN payment_month = {$lastMonth}
                            AND payment_year = {$lastYear}
                            THEN amount ELSE 0
                        END
                    ) as last_deposit
                "),

                DB::raw("
                    SUM(
                        CASE
                            WHEN payment_month = {$currentMonth}
                            AND payment_year = {$currentYear}
                            THEN amount ELSE 0
                        END
                    ) as current_deposit
                "),

                DB::raw("
                    SUM(
                        CASE
                            WHEN payment_month = {$nextMonth}
                            AND payment_year = {$nextYear}
                            THEN amount ELSE 0
                        END
                    ) as next_month_deposit
                ")
            )
            ->groupBy('rm_id')
            ->get()
            ->keyBy('rm_id');

        $response = [];

        $lastEntries = [];

        if ($isLastEntry) {

            $lastEntryIds = SavingRmEntries::whereIn('rm_id', $rmIds)
                ->selectRaw('MAX(id) as id')
                ->groupBy('rm_id')
                ->pluck('id');

            $lastEntries = SavingRmEntries::select('rm_id', 'amount', 'payment_month', 'payment_year', 'entry_date')->whereIn('id', $lastEntryIds)
                ->get()
                ->keyBy('rm_id');
        }

        foreach ($rmIds as $rmId) {
            $rm = $rms->get($rmId);

            if (!$rm) {
                continue;
            }

            $entry = $entries->get($rmId);

            $lastDepositAmount    = (int)($entry->last_deposit ?? 0);
            $currentDepositAmount = (int)($entry->current_deposit ?? 0);
            $nextDepositAmount    = (int)($entry->next_month_deposit ?? 0);

            // Monthly amount history
            $history = Helper::getEffectiveMonthlyAmount(
                $rmId,
                null,
                null,
                'all'
            );

            $openMonth = (int)$rm->open_month;
            $openYear  = (int)$rm->open_year;

            $previousMonthlyAmount = Helper::resolveMonthlyAmount(
                $history,
                $rm->monthly_amount,
                $lastMonth,
                $lastYear
            );

            $currentMonthlyAmount = Helper::resolveMonthlyAmount(
                $history,
                $rm->monthly_amount,
                $currentMonth,
                $currentYear
            );

            $nextMonthlyAmount = Helper::resolveMonthlyAmount(
                $history,
                $rm->monthly_amount,
                $nextMonth,
                $nextYear
            );

            $trackingMonth = 'current';

            $lastMonthValid = !(
                $lastYear < $openYear ||
                ($lastYear == $openYear && $lastMonth < $openMonth)
            );

            if (
                $lastMonthValid &&
                $lastDepositAmount < $previousMonthlyAmount
            ) {
                $month = $lastMonth;
                $year = $lastYear;
                $remainingAmount = $previousMonthlyAmount - $lastDepositAmount;
                $deposit = $lastDepositAmount;
                $trackingMonth = 'previous';
            } elseif (
                $currentDepositAmount < $currentMonthlyAmount
            ) {
                $month = $currentMonth;
                $year = $currentYear;
                $remainingAmount = $currentMonthlyAmount - $currentDepositAmount;
                $deposit = $currentDepositAmount;
            } else {
                $month = $nextMonth;
                $year = $nextYear;
                $remainingAmount = $nextMonthlyAmount - $nextDepositAmount;
                $deposit = $nextDepositAmount;
                $trackingMonth = 'advance';
            }

            $response[$rmId] = [
                'month' => $month,
                'year' => $year,
                'last_month' => $lastMonth,
                'last_year' => $lastYear,
                'current_month' => $currentMonth,
                'current_year' => $currentYear,
                'last_month_deposit' => $lastDepositAmount,
                'current_month_deposit' => $currentDepositAmount,
                'deposit_amount' => $deposit,
                'remaining_amount' => $remainingAmount,
                'monthly_amount' => $currentMonthlyAmount,
                'tracking_month' => $trackingMonth,
                'total_deposit_amount'  => (int)($entry->total_deposit ?? 0),
                'last_entry' => null
            ];
            if ($isLastEntry && isset($lastEntries[$rmId])) {
                $response[$rmId]['last_entry'] = $lastEntries[$rmId];
            }
        }


        return $response;
    }
}
