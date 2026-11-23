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

        // Define the criteria to find the existing record
        $attributes = [
            'tokenable_type' => $tokenableType,
            'tokenable_id'   => $tokenableId,
        ];

        // If deviceType is provided, include it in the search criteria 
        // so different devices for the same user don't overwrite each other.
        if ($deviceType !== null) {
            $attributes['device_type'] = $deviceType;
        }

        // Values to update or insert
        $values = [
            'token'        => $token,
            'device_type'  => $deviceType,
            'last_used_at' => now(),
        ];

        FcmToken::updateOrCreate($attributes, $values);
    }

    /**
     * Send a push notification to a User or SavingCustomer.
     */
    public function sendToModel($notifiable, string $title, string $body, array $data = []): void
    {
        $tokens = is_array($notifiable)
            ? $notifiable
            : $notifiable->fcmTokens()->pluck('token')->toArray();

        // Remove empty/null values and duplicates
        $tokens = array_values(array_unique(array_filter($tokens)));

        if (empty($tokens)) {
            return;
        }

        $messaging = app('firebase.messaging');

        foreach ($tokens as $token) {
            $message = CloudMessage::withTarget('token', $token)
                ->withNotification([
                    'title' => $title,
                    'body' => $body,
                ])
                ->withData($data);

            $messaging->send($message);
        }
    }
}
