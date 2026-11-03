<?php

return [
    'route_prefix' => env('ARTIST_NINJA_ROUTE_PREFIX', 'artist-ninja'),
    'middleware' => ['web'],
    'invoice_ninja' => [
        'base_url' => env('INVOICE_NINJA_URL'),
        'api_token' => env('INVOICE_NINJA_API_TOKEN'),
        'company_key' => env('INVOICE_NINJA_COMPANY_KEY'),
    ],
];
