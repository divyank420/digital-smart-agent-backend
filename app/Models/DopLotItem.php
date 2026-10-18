<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DopLotItem extends Model
{
    use HasFactory;

    protected $table = 'dop_lot_items';

    protected $fillable = [
        'lot_id',
        'account_id',
        'account_number',
        'customer_name',
        'installment',
        'amount',
        'is_synced',
        'dop_remarks',
    ];

    protected $casts = [
        'amount'      => 'decimal:2',
        'is_synced'   => 'boolean',
    ];

    /**
     * Get the parent Lot metadata dashboard file that owns this specific row item.
     */
    public function lot(): BelongsTo
    {
        return $this->belongsTo(DopLot::class, 'lot_id', 'id');
    }
}