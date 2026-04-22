<?php

namespace App\Observers;

use App\Models\RmMonthlyAmountHistory;
use App\Models\SavingRm;

class SavingRmObserver
{
    /**
     * Handle the SavingRm "created" event.
     */
    public function created(SavingRm $savingRm): void
    {
        RmMonthlyAmountHistory::create([
            'rm_id'              => $savingRm->id,
            'effective_month'    => $savingRm->opening_month ?? date('m'),
            'effective_year'     => $savingRm->opening_year ?? date('Y'),
            'monthly_amount'     => $savingRm->monthly_amount,
            'installment_amount' => $savingRm->installment_amount,
            'status'             => 1
        ]);
    }

    /**
     * Handle the SavingRm "updated" event.
     */
    public function updated(SavingRm $savingRm): void
    {
        //
    }

    /**
     * Handle the SavingRm "deleted" event.
     */
    public function deleted(SavingRm $savingRm): void
    {
        //
    }

    /**
     * Handle the SavingRm "restored" event.
     */
    public function restored(SavingRm $savingRm): void
    {
        //
    }

    /**
     * Handle the SavingRm "force deleted" event.
     */
    public function forceDeleted(SavingRm $savingRm): void
    {
        //
    }
}
