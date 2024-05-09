<?php

return [
    'navigation_sort' => 2001,

    'forge_api_key' => env('FORGE_API_KEY'),
    'forge_api_url' => env('FORGE_API_URL', 'https://forge.laravel.com/api/v1'),
    'forge_server_filter' => env('FORGE_SERVER_FILTER', ''), // string to find in server name, optional
];
