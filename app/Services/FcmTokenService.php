<?php

namespace App\Services;

use App\Models\FcmToken;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;

class FcmTokenService
{
    /**
     * Register or update the FCM token.
     */
    public function register($user, string $token, ?string $deviceType = null): void
    {
        $tokenableType = get_class($user);
        $tokenableId = $user->id;

        // Case 1: Check if the exact same token + type + id already exists
        $exactMatch = FcmToken::where('token', $token)
            ->where('tokenable_type', $tokenableType)
            ->where('tokenable_id', $tokenableId)
            ->exists();

        if ($exactMatch) {
            return;
        }

        // Case 2: Check if this user already has a record (possibly with an old/different token)
        $userToken = FcmToken::where('tokenable_type', $tokenableType)
            ->where('tokenable_id', $tokenableId)
            ->when($deviceType, function ($query) use ($deviceType) {
                return $query->where('device_type', $deviceType);
            })
            ->first();


        if ($userToken) {
            // User exists, but the token is different -> Update existing record
            $userToken->update([
                'token' => $token,
                'device_type' => $deviceType,
                'last_used_at' => now(),
            ]);
        } else {
            // Neither exists -> Create a brand new record
            FcmToken::create([
                'token' => $token,
                'tokenable_type' => $tokenableType,
                'tokenable_id' => $tokenableId,
                'device_type' => $deviceType,
                'last_used_at' => now(),
            ]);
        }
    }

    /**
     * Send a push notification to a User or SavingCustomer.
     */
    public function sendToModel($notifiable, string $title, string $body, array $data = []): void
    {

        $tokens = $notifiable->fcmTokens()->pluck('token')->toArray();

        if (empty($tokens)) {
            return;
        }

        foreach ($tokens as $token) {
            $message = CloudMessage::withTarget('token', $token)
                ->withNotification([
                    'title' => $title,
                    'body' => $body,
                ])
                ->withData($data);

            app('firebase.messaging')->send($message);
        }
    }
}
