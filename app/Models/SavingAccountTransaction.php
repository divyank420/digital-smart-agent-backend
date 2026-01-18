<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingAccountTransaction extends Model
{
    use HasFactory;
    protected $table = 'saving_account_transactions';

    protected $fillable = [
        'account_id',
        'transactionable_id',
        'transactionable_type',
        'transaction_type',
        'amount',
        'balance_after',
        'remarks',
    ];

    public function transactionable()
    {
        return $this->morphTo();
    }
}
