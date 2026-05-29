<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\CompanyAccount;
use App\Models\SavingAccountTransaction;

trait BankTransactionTrait
{
    /**
     * Create Bank Transaction
     *
     * @param CompanyAccount $account
     * @param string $transactionType (credit/debit)
     * @param float $amount
     * @param mixed $transactionableModel
     * @param string|null $referenceNo
     * @param string|null $remarks
     *
     * @return SavingAccountTransaction
     * @throws Exception
     */
    public function createBankTransaction(
        CompanyAccount $account,
        string $transactionType,
        float $amount,
        $transactionableModel = null,
        ?string $referenceNo = null,
        ?string $remarks = null
    ): SavingAccountTransaction {

        return DB::transaction(function () use (
            $account,
            $transactionType,
            $amount,
            $transactionableModel,
            $referenceNo,
            $remarks
        ) {

            /**
             * Lock row for concurrent safety
             */
            $account = CompanyAccount::lockForUpdate()
                ->find($account->id);

            if (!$account) {
                throw new Exception('Bank account not found.');
            }

            /**
             * Calculate balance
             */
            if ($transactionType === 'credit') {

                $updatedBalance = $account->current_balance + $amount;

            } elseif ($transactionType === 'debit') {

                if ($account->current_balance < $amount) {
                    throw new Exception('Insufficient balance.');
                }
                $updatedBalance = $account->current_balance - $amount;

            } else {
                throw new Exception('Invalid transaction type.');
            }

            /**
             * Update account balance
             */
            $account->update([
                'current_balance' => $updatedBalance
            ]);

            /**
             * Create transaction
             */
            $transaction = SavingAccountTransaction::create([
                'account_id' => $account->id,
                'transactionable_id' => $transactionableModel?->id,
                'transactionable_type' => $transactionableModel
                    ? get_class($transactionableModel)
                    : null,
                'transaction_type' => $transactionType,
                'amount' => $amount,
                'balance_after' => $updatedBalance,
                'reference_no' => $referenceNo
                    ?? $this->generateReferenceNo(),
                'remarks' => $remarks,
            ]);
            return $transaction;
        });
    }

    /**
     * Generate Reference Number
     */
    protected function generateReferenceNo(): string
    {
        return 'TXN-' . strtoupper(uniqid());
    }
}