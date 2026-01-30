<?php

// config for CustomFields /LaravelCustomFields
return [
    'models' => [
        // 'user' => 'App\Models\User',
    ],
    'routing' => [
        'api' => [
            'enabled' => true,
            'prefix' => 'api/custom-fields',
            'middleware' => ['api'],
        ],
        'web' => [
            'enabled' => false,
            'prefix' => 'custom-fields',
            'middleware' => ['web'],
        ],
    ],

    /**
     * Integrity Check (Sealed Lifecycle)
     * If enabled, the package will throw an exception if you attempt to save
     * custom fields that haven't passed through the service's validation.
     */
    'strict_validation' => true,
];
