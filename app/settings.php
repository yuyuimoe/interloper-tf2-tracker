<?php

define('APP_ROOT', __DIR__);
define('SRC_ROOT', APP_ROOT . '/src');

return [
    'settings' => [
        'slim' => [
            'displayErrorDetails' => true,
            'logErrors' => true,
            'logErrorDetails' => true,
        ],
        'doctrine' => [
            'dev_mode' => true,
            'cache_dir' => APP_ROOT . '/var/doctrine',
            'metadata_dirs' => [SRC_ROOT . '/Domain'],
            'connection' => [
                'driver' => 'pdo_pgsql',
                'host' => 'postgres',
                'port' => 5432,
                'dbname' => 'interlope',
                'user' => 'interlope',
                'password' => 'kulcs',
                'charset' => 'utf-8',
            ]
        ]
    ]
];