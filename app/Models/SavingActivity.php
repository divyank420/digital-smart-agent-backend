<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingActivity extends Model
{
    use HasFactory;

    protected $table = 'saving_activities';

    protected $fillable = [
        'user_id',
        'activityable_id',
        'activityable_type',
        'action',
        'message',
        'meta',
        'ip_address',
        'user_agent',
    ];

    /**
     * Cast meta to array automatically
     */
    protected $casts = [
        'meta' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Polymorphic relation to the affected model
     */
    public function activityable()
    {
        return $this->morphTo();
    }

    /**
     * Scope to filter by action
     */
    public function scopeAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope for recent activities
     */
    public function scopeRecent($query, $limit = 10)
    {
        return $query->latest('created_at')->take($limit);
    }

    /**
     * Optional helper to log an activity easily
     */
    public static function log($userId, $action, $activityable, $message = null, $meta = null)
    {
        return self::create([
            'user_id' => $userId,
            'activityable_id' => $activityable->id ?? null,
            'activityable_type' => $activityable ? get_class($activityable) : null,
            'action' => $action,
            'message' => $message ?? $action,
            'meta' => $meta,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
