<?php

return [
'dojah' => [
    'app_id' => env('DOJAH_APP_ID'),
    'secret_key' => env('DOJAH_SECRET_KEY'),
    'base_url' => env('DOJAH_BASE_URL', 'https://api.dojah.io/api/v1/general/account?'),
],
    
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

];
