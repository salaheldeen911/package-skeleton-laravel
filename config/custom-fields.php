<?php

// config for CustomFields /LaravelCustomFields
return [
    'models' => [
        // 'post' => 'App\Models\Post',
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

    /**
     * File Upload Configuration
     */
    'files' => [
        'disk' => 'public',
        'path' => 'custom-fields',
        'cleanup' => true, // Automatically delete files when updated or model deleted
    ],
];
