<?php

namespace App\Observers;

use App\Models\SavingRmEntries;
use App\Models\SavingAccountTransaction;
use App\Models\CompanyAccount;
use Illuminate\Support\Facades\DB;

class SavingRmEntriesObserver
{
    public function created(SavingRmEntries $entry): void
    {
        if ($entry->amount_type !== 'online') {
            return;
        }
        DB::transaction(function () use ($entry) {

            $account = CompanyAccount::lockForUpdate()
                ->findOrFail($entry->account_id);

            $newBalance = $account->current_balance + $entry->amount;

            // Create the ledger entry
            $entry->transaction()->create([
                'account_id'       => $account->id,
                'transaction_type' => 'credit',
                'amount'           => $entry->amount,
                'balance_after'    => $newBalance,
                'remarks'          => 'RM online entry created',
            ]);

            $account->update(['current_balance' => $newBalance]);
        });
    }

    public function updated(SavingRmEntries $entry): void
    {
        DB::transaction(function () use ($entry) {

            $old = $entry->getOriginal();
            $oldType      = $old['amount_type'];
            $newType      = $entry->amount_type;

            $oldAmount    = $old['amount'];
            $newAmount    = $entry->amount;

            $oldAccountId = $old['account_id'];
            $newAccountId = $entry->account_id;

            $transaction = SavingAccountTransaction::where([
                'transactionable_id'   => $entry->id,
                'transactionable_type' => SavingRmEntries::class,
            ])->first();

            // ONLINE → CASH (DELETE)
            if ($oldType === 'online' && $newType !== 'online') {
                $this->rollbackTransaction($transaction, $entry);
                return;
            }

            // CASH → ONLINE (CREATE)
            if ($oldType !== 'online' && $newType === 'online') {
                $this->created($entry); // transaction_id is updated here
                return;
            }

            // ONLINE → ONLINE
            if ($newType !== 'online' || !$transaction) {
                return;
            }

            // ACCOUNT CHANGED
            if ($oldAccountId != $newAccountId) {
                $this->moveTransaction($transaction, $entry, $newAccountId, $newAmount);
                return;
            }

            // SAME ACCOUNT → AMOUNT CHANGED
            $difference = $newAmount - $oldAmount;
            if ($difference !== 0) {
                $this->adjustTransaction($transaction, $newAmount, $difference);
            }
        });
    }

    public function deleted(SavingRmEntries $entry): void
    {
        if ($entry->amount_type !== 'online') {
            return;
        }

        DB::transaction(function () use ($entry) {
            $transaction = SavingAccountTransaction::where([
                'transactionable_id'   => $entry->id,
                'transactionable_type' => SavingRmEntries::class,
            ])->first();

            $this->rollbackTransaction($transaction, $entry);
        });
    }

    /* =====================================================
     | HELPER METHODS
     |=====================================================*/

    protected function rollbackTransaction(?SavingAccountTransaction $transaction, SavingRmEntries $entry): void
    {
        if (!$transaction) return;

        $account = CompanyAccount::lockForUpdate()
            ->findOrFail($transaction->account_id);

        $account->decrement('current_balance', $transaction->amount);

        $transaction->delete();

        // Remove account_id from entry
        $entry->forceFill(['account_id' => null])->saveQuietly();
    }

    protected function moveTransaction(
        SavingAccountTransaction $transaction,
        SavingRmEntries $entry,
        int $newAccountId,
        float $newAmount
    ): void {
        // Rollback old account
        $oldAccount = CompanyAccount::lockForUpdate()
            ->findOrFail($transaction->account_id);
        $oldAccount->decrement('current_balance', $transaction->amount);

        // Credit new account
        $newAccount = CompanyAccount::lockForUpdate()
            ->findOrFail($newAccountId);

        $newBalance = $newAccount->current_balance + $newAmount;

        $transaction->update([
            'account_id'    => $newAccount->id,
            'amount'        => $newAmount,
            'balance_after' => $newBalance,
            'remarks'       => 'RM online entry moved account',
        ]);

        $newAccount->update(['current_balance' => $newBalance]);
    }

    protected function adjustTransaction(
        SavingAccountTransaction $transaction,
        float $newAmount,
        float $difference
    ): void {
        $account = CompanyAccount::lockForUpdate()
            ->findOrFail($transaction->account_id);

        $newBalance = $account->current_balance + $difference;

        $transaction->update([
            'amount'        => $newAmount,
            'balance_after' => $newBalance,
            'remarks'       => 'RM online entry updated',
        ]);

        $account->update(['current_balance' => $newBalance]);
    }
}
