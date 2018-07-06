<?php
/**
 * The staging database settings. These get merged with the global settings.
 */

return [
    'default' => [
        'connection' => [
            'dsn' => 'mysql:host=localhost;dbname=fuel_staging',
            'username' => 'fuel_app',
            'password' => 'super_secret_password',
        ],
    ],
];
