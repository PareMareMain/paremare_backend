<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN','support@clubj.app'),
        'secret' => env('MAILGUN_SECRET','c324be76efc6eb4ad31cbd7133886c61-bdb2c8b4-182d5834'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'smtp.mailgun.org'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    's3' => [
        'key' => env('AWS_ACCESS_KEY_ID','AKIA4LHAYFHIYVY3IMNA'),
        'secret' => env('AWS_SECRET_ACCESS_KEY','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'),
        'region' => env('AWS_DEFAULT_REGION', 'me-south-1'),
    ],
    'twilio'=>[
        'number'=>env('TWILIO_NUMBER','+12566074381'),
        'twilio_token'=>env('TWILIO_TOKEN','f9e7b9097bddb9409bf29b9f44033279'),
        'twilio_sid'=>env('TWILIO_SID','ACaed4cb27f4eecf81985daf79bbe2fbce'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_CALLBACK_URL'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_CALLBACK_URL'),
    ],

    'apple' => [
        'client_id' => env('APPLE_CLIENT_ID'),
        'client_secret' => env('APPLE_CLIENT_SECRET'),
        'redirect' => env('APPLE_CALLBACK_URL'),
    ],


    'stripe' => [
        'model' => App\Models\User::class,
        'publish_key' => env('STRIPE_KEY'),
        'secret_key' => env('STRIPE_SECRET'),
      ],
];
