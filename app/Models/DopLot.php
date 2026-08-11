<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DopLot extends Model
{
    protected $table = 'dop_lots';

    protected $fillable = [
        'company_id',
        'agent_id',
        'batch_id',
        'lot_number',
        'lot_date',
        'lot_remark',
        'total_accounts',
        'total_amount',
        'defaulter_amount',
        'rebate_amount',
        'reference_no',
        'status',
        'synced_at',
        'sync_error_log',
    ];

    protected $casts = [
        'lot_date' => 'date',
        'synced_at' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(DopLotItem::class, 'lot_id');
    }

    public function company()
    {
        return $this->belongsTo(SavingCompany::class, 'company_id', 'id');
    }
    public function agent()
    {
        return $this->belongsTo(DopAgent::class, 'agent_id', 'id');
    }
}
