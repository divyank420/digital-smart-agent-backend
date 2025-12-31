<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionalMessage extends Model
{
    protected $table = 'saving_promotional_messages';
    protected $fillable = [
        'title',
        'message',
        'is_active',
        'start_date',
        'end_date',
        'position'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            });
    }
}
