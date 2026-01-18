<?php

namespace App\Observers;

use App\Models\SavingExpenses;
use App\Models\SavingAccountTransaction;
use App\Models\CompanyAccount;
use Illuminate\Support\Facades\DB;

class SavingExpensesObserver
{
    /**
     * Handle the SavingExpenses "created" event.
     */
    public function created(SavingExpenses $expense): void
    {
        if ($expense->amount_type !== 'online') {
            return;
        }

        DB::transaction(function () use ($expense) {

            $account = CompanyAccount::lockForUpdate()
                ->findOrFail($expense->account_id);

            $newBalance = $account->current_balance - $expense->amount;

            $expense->transaction()->create([
                'account_id'       => $account->id,
                'transaction_type' => 'debit',
                'amount'           => $expense->amount,
                'balance_after'    => $newBalance,
                'remarks'          => 'Expense online entry created',
            ]);

            $account->update(['current_balance' => $newBalance]);
        });
    }

    /**
     * Handle the SavingExpenses "updated" event.
     */
    public function updated(SavingExpenses $expense): void
    {
        DB::transaction(function () use ($expense) {

            $old = $expense->getOriginal();
            $oldType      = $old['amount_type'];
            $newType      = $expense->amount_type;

            $oldAmount    = $old['amount'];
            $newAmount    = $expense->amount;

            $oldAccountId = $old['account_id'];
            $newAccountId = $expense->account_id;

            $transaction = SavingAccountTransaction::where([
                'transactionable_id'   => $expense->id,
                'transactionable_type' => SavingExpenses::class,
            ])->first();

            // ONLINE → CASH (DELETE)
            if ($oldType === 'online' && $newType !== 'online') {
                $this->rollbackTransaction($transaction, $expense);
                return;
            }

            // CASH → ONLINE (CREATE)
            if ($oldType !== 'online' && $newType === 'online') {
                $this->created($expense);
                return;
            }

            // ONLINE → ONLINE
            if ($newType !== 'online' || !$transaction) {
                return;
            }

            // ACCOUNT CHANGED
            if ($oldAccountId != $newAccountId) {
                $this->moveTransaction($transaction, $expense, $newAccountId, $newAmount);
                return;
            }

            // SAME ACCOUNT → AMOUNT CHANGED
            $difference = $newAmount - $oldAmount;
            if ($difference !== 0) {
                $this->adjustTransaction($transaction, $newAmount, $difference);
            }
        });
    }

    /**
     * Handle the SavingExpenses "deleted" event.
     */
    public function deleted(SavingExpenses $expense): void
    {
        if ($expense->amount_type !== 'online') {
            return;
        }

        DB::transaction(function () use ($expense) {
            $transaction = SavingAccountTransaction::where([
                'transactionable_id'   => $expense->id,
                'transactionable_type' => SavingExpenses::class,
            ])->first();

            $this->rollbackTransaction($transaction, $expense);
        });
    }

    /* =====================================================
     | HELPER METHODS
     |=====================================================*/

    protected function rollbackTransaction(?SavingAccountTransaction $transaction, SavingExpenses $expense): void
    {
        if (!$transaction) return;

        $account = CompanyAccount::lockForUpdate()
            ->findOrFail($transaction->account_id);

        $account->increment('current_balance', $transaction->amount); // rollback debit

        $transaction->delete();

        $expense->forceFill(['account_id' => null])->saveQuietly();
    }

    protected function moveTransaction(
        SavingAccountTransaction $transaction,
        SavingExpenses $expense,
        int $newAccountId,
        float $newAmount
    ): void {
        // Rollback old account
        $oldAccount = CompanyAccount::lockForUpdate()
            ->findOrFail($transaction->account_id);
        $oldAccount->increment('current_balance', $transaction->amount); // reverse old debit

        // Debit new account
        $newAccount = CompanyAccount::lockForUpdate()
            ->findOrFail($newAccountId);
        $newBalance = $newAccount->current_balance - $newAmount;

        $transaction->update([
            'account_id'    => $newAccount->id,
            'amount'        => $newAmount,
            'balance_after' => $newBalance,
            'remarks'       => 'Expense online entry moved account',
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

        $newBalance = $account->current_balance - $difference; // adjust debit

        $transaction->update([
            'amount'        => $newAmount,
            'balance_after' => $newBalance,
            'remarks'       => 'Expense online entry updated',
        ]);

        $account->update(['current_balance' => $newBalance]);
    }
}
