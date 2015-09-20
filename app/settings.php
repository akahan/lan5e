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
            'dsn'  => 'mysql:host=lan5e.mysql;dbname=lan5e',
            'user' => 'lan5e_mysql',
            'pass' => 'GeThK-1Q'
        ]
    ],
];
