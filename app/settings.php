<?php
return [
    'settings' => [
        // View settings
        'view' => [
            'template_path' => __DIR__ . '/templates',
            'twig' => [
                // 'cache' => __DIR__ . '/../cache/twig',
                'debug' => true,
                'auto_reload' => true,
            ],
        ],

        // monolog settings
        'logger' => [
            'name' => 'app',
            'path' => __DIR__ . '/../log/app.log',
        ],

        'db' => [
            'dsn'  => 'mysql:host=127.0.0.1;dbname=lan5e',
            'user' => 'lan5e',
            'pass' => 'lan5e'
        ]
    ],
];
