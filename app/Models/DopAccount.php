<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DopAccount extends Model
{
    protected $table = 'dop_accounts';

    protected $fillable = [
        'company_id',
        'account_no',
        'account_name',
        'short_code',
        'monthly_amount',
        'total_installments',
        'next_due_date',
        'total_paid_installments',
        'account_opening_date',
        'pending_installment',
        'defaulter_installment',
        'last_deposit_date',
        'maturity_date',
        'maturity_status',
    ];

    protected $casts = [
        'account_opening_date' => 'date:Y-m-d',
        'last_deposit_date'    => 'date:Y-m-d',
        'maturity_date'        => 'date:Y-m-d',
        'monthly_amount'       => 'decimal:2',
        'total_paid_installments' => 'integer',
        'raw_scraped_data_dump' => 'array'
    ];

    public function agent(){
        return $this->belongsTo(DopAgent::class, 'agent_id', 'id');
    }
}
