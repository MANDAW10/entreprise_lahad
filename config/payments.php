<?php

return [
    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
    ],
    'paypal' => [
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'secret' => env('PAYPAL_SECRET'),
        'mode' => env('PAYPAL_MODE', 'sandbox'),
    ],
    'wave' => [
        'enabled' => env('WAVE_ENABLED', false),
    ],
    'orange_money' => [
        'enabled' => env('ORANGE_MONEY_ENABLED', false),
    ],
];
