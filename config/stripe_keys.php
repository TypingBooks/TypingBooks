<?php



return [
    'api_key'=> env('STRIPE_API_KEY', null), 
    'endpoint_secret' => env('STRIPE_ENDPOINT_SECRET', null), 
    'publish_key' => env('STRIPE_PUBLISH_KEY', null), 
];
