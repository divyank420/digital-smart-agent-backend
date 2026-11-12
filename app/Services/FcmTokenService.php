<?php 

namespace App\Services;

use App\Models\FcmToken;

class FcmTokenService
{
    public function register($user, string $token, ?string $deviceType = null): void
    {
        FcmToken::updateOrCreate(
            [
                'token' => $token,
            ],
            [
                'tokenable_type' => get_class($user),
                'tokenable_id' => $user->id,
                'device_type' => $deviceType,
                'last_used_at' => now(),
            ]
        );
    }
}