<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\NotificationRecipient;

class NotificationService
{
    public function send(
        iterable $recipient,
        string $title,
        string $message,
        ?string $type = null,
        array $data = []
    ) {
        $notification = Notification::create([
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'data' => $data,
        ]);


        foreach ($recipients as $recipient) {
            NotificationRecipient::create([
                'notification_id' => $notification->id,
                'recipient_type' => get_class($recipient),
                'recipient_id' => $recipient->id,
            ]);
        }

        return $notification;
    }
}
