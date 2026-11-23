<?php

return [
    'MANUAL_WHATSAPP_UPDATES' => 'Manual Whatsapp Updates',
    'AUTOMATED_EMAIL_ALERTS'  => 'Automated Email Alerts',

    'statuses' => [
        'PENDING'   => 'Pending Approval',
        'COMPLETED' => 'Completed Successfully',
    ],
    'current_version' => env('APP_CURRENT_VERSION', "2.1.5"),
    'is_force_update' => env('APP_FORCE_UPDATE', true),
];

