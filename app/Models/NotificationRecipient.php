<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationRecipient extends Model
{
    protected $fillable = [
        'notification_id',
        'recipient_type',
        'recipient_id',
        'is_read',
        'read_at'
    ];

    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }

    public function recipient()
    {
        return $this->morphTo();
    }
}
