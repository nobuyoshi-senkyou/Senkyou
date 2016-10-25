<?php
return [
    /**
     * Default Database Connection Name
     *
     * Supported: 'mysql'
     */
    'default' => env('DB_CONNECTION', 'mysql'),

    /**
     * Database Connections
     */
    'connections' => [
        'mysql' => [
            'host' => env('DB_HOST', 'localhost'),
            'dbname' => env('DB_DATABASE', 'ninja'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'prefix' => '',
            'charset' => 'uft8',
        ],
    ],
];