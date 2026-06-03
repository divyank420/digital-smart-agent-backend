<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FcmToken extends Model
{
    protected $fillable = [
        'tokenable_type',
        'tokenable_id',
        'token',
        'device_type',
        'last_used_at',
    ];

    protected $casts = [
        'last_used_at' => 'datetime'
    ];

    public function tokenable()
    {
        return $this->morphTo();
    }
}
