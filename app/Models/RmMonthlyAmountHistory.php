<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmMonthlyAmountHistory extends Model
{
    use HasFactory;

    protected $table = 'rm_monthly_amounts_history';

    protected $fillable = [
        'rm_id',
        'monthly_amount',
        'installment_amount',
        'effective_month',
        'effective_year',
        'status',
    ];
    protected $casts = [
        'monthly_amount' => 'integer',        
        'installment_amount' => 'integer',        

    ];

    public function rm()
    {
        return $this->belongsTo(SavingRm::class, 'rm_id');
    }
}
