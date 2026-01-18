<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyAccount extends Model
{
    use HasFactory;

    protected $table = 'saving_company_accounts';

     protected $fillable = [
        'company_id',
        'customer_name',
        'bank_name',
        'account_type',
        'opening_balance',
        'current_balance',
        'is_active'
    ];

    protected $casts = [
        'current_balance'=>'integer',
        'is_active' => 'boolean',
    ];
}
