<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    */

    'paths' => [
        'api/*',
        'cart-locations',  // your custom route
        'sanctum/csrf-cookie'
    ],

    'allowed_methods' => ['*'],  // Allow GET, POST, OPTIONS, etc.

    'allowed_origins' => [
        'https://multi-location-v1.myshopify.com',  // Your Shopify store
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],  // Allow all headers

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
