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
        'account_holder_name',
        'bank_name',
        'account_type',
        'opening_balance',
        'current_balance',
        'is_active'
    ];

    protected $casts = [
        'opening_balance' => 'integer',
        'current_balance' => 'integer',
        'is_active' => 'boolean',
    ];

    public function transactions()
    {
        return $this->hasMany(
            SavingAccountTransaction::class,
            'account_id'
        );
    }

    public function company()
    {
        return $this->belongsTo(SavingCompany::class);
    }
}
