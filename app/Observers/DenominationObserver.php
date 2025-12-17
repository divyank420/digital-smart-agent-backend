<?php

namespace App\Observers;

use App\Models\SavingDenomination;

class DenominationObserver
{
    public function creating(SavingDenomination $savingDenomination)
    {
        $total = 
        $savingDenomination->n_2000 * 2000 + 
        $savingDenomination->n_500 * 500 + 
        $savingDenomination->n_200 * 200 +
        $savingDenomination->n_100 * 100 +
        $savingDenomination->n_50 * 50 +
        $savingDenomination->n_20 * 20 +
        $savingDenomination->n_10 * 10 +
        $savingDenomination->online;

        $savingDenomination->total = $total;
    }
    /**
     * Handle the SavingDenomination "created" event.
     *
     * @param  \App\Models\SavingDenomination  $savingDenomination
     * @return void
     */
    public function created(SavingDenomination $savingDenomination)
    {  
        /* $total = 
        $savingDenomination->n_2000 * 2000 + 
        $savingDenomination->n_500 * 500 + 
        $savingDenomination->n_200 * 200 +
        $savingDenomination->n_100 * 100 +
        $savingDenomination->n_50 * 50 +
        $savingDenomination->n_20 * 20 +
        $savingDenomination->n_10 * 10 +
        $savingDenomination->online;

        $savingDenomination->total = $total;
        $savingDenomination->save(); */
        
    }

    /**
     * Handle the SavingDenomination "updating" event.
     *
     * @param  \App\Models\SavingDenomination  $savingDenomination
     * @return void
     */
    public function updating(SavingDenomination $savingDenomination)
    {
        
        $total = 
        $savingDenomination->n_2000*2000 + 
        $savingDenomination->n_500*500 + 
        $savingDenomination->n_200*200 +
        $savingDenomination->n_100*100 +
        $savingDenomination->n_50*50 +
        $savingDenomination->n_20*20 +
        $savingDenomination->n_10*10 +
        $savingDenomination->online;

        $savingDenomination->total = $total;
    }

    /**
     * Handle the SavingDenomination "deleted" event.
     *
     * @param  \App\Models\SavingDenomination  $savingDenomination
     * @return void
     */
    public function deleted(SavingDenomination $savingDenomination)
    {
        //
    }

    /**
     * Handle the SavingDenomination "restored" event.
     *
     * @param  \App\Models\SavingDenomination  $savingDenomination
     * @return void
     */
    public function restored(SavingDenomination $savingDenomination)
    {
        //
    }

    /**
     * Handle the SavingDenomination "force deleted" event.
     *
     * @param  \App\Models\SavingDenomination  $savingDenomination
     * @return void
     */
    public function forceDeleted(SavingDenomination $savingDenomination)
    {
        //
    }
}
