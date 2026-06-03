<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'title',
        'message',
        'type',
        'data'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function recipients()
    {
        return $this->hasMany(NotificationRecipient::class);
    }
}
