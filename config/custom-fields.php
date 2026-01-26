<?php

// config for CustomFields /LaravelCustomFields
return [
    'models' => [
        // 'user' => 'App\Models\User',
    ],
    'routing' => [
        'api' => [
            'enabled' => false,
            'prefix' => 'api/custom-fields',
            'middleware' => ['api'],
        ],
        'web' => [
            'enabled' => false,
            'prefix' => 'custom-fields',
            'middleware' => ['web'],
        ],
    ],
];
