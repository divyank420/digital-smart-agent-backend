<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnboardingRequest extends Model
{
    protected $fillable = [
        'uuid',
        'company_name',
        'owner_name',
        'mobile',
        'email',
        'dop_id',
        'dop_password',
        'otp_hash',
        'otp_sent_at',
        'otp_expires_at',
        'otp_attempts',
        'otp_verified',
        'status',
        'dop_agents',
        'sub_agents',
        'selected_plans',
        'current_step',
        'expires_at',
    ];

    protected $casts = [
        'selected_plans' => 'array',
    ];
}
