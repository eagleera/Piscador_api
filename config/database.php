<?php

return [
    'default' => 'mongodb',
    'connections' => [
        'mongodb' => [
            'driver' => 'mongodb',
            'host' => env('MONGO_HOST', 'localhost'),
            'port' => env('MONGO_PORT', 27017),
            'database' => env('MONGO_DATABASE'),
            'username' => env('MONGO_USERNAME'),
            'password' => env('MONGO_PASSWORD'),
            'options' => [
                'database' => 'admin'
            ]
        ],
    ],
    'migrations' => 'migrations',
];