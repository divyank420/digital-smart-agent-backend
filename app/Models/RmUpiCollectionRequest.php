<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RmUpiCollectionRequest extends Model
{
    protected $table = 'rm_upi_collection_requests';

    protected $fillable = [
        'company_id',
        'customer_id',
        'rm_id',
        'account_id',
        'amount',
        'payee_upi_id',
        'screenshot_path',
        'status',
        'rejection_reason',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:0',
        'reviewed_at' => 'datetime',
    ];

    public function savingRm(): BelongsTo
    {
        return $this->belongsTo(SavingRm::class, 'rm_id');
    }

    public function savingCustomer(): BelongsTo
    {
        return $this->belongsTo(SavingCustomer::class, 'customer_id');
    }

    public function savingCompany(): BelongsTo
    {
        return $this->belongsTo(SavingCompany::class, 'company_id');
    }
}