<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'facebook' => [
        'client_id' => '665634956943121',
        'client_secret' => 'e850cae3ece1b14e999e024792c9bed0',
        'redirect' => env('WEB_URL') . '/facebook/callback',
    ],
    'google' => [
        'client_id' => '122536444277-au7h7vvj5u3pnkhjojj9d4om6ojt0147.apps.googleusercontent.com',
        'client_secret' => 'qnuWxR4UMRYLuNsQwaoNpb-2',
        'redirect' => env('WEB_URL') . '/callback/google',
    ],

];
