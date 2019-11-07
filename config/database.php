<?php

return [
   'default' => 'pgsql',
   'migrations' => 'migrations',
   'connections' => [
        'pgsql' => [
            'driver'    => 'pgsql',
            'host'      => env('DB_HOST'),
            'port'      => env('DB_PORT'),
            'database'  => env('DB_DATABASE'),
            'username'  => env('DB_USERNAME'),
            'password'  => env('DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
         ],
        'test' => [
            'driver'    => 'pgsql',
            'host'      => env('DB_HOST_TEST'),
            'port'      => env('DB_PORT_TEST'),
            'database'  => env('DB_DATABASE_TEST'),
            'username'  => env('DB_USERNAME_TEST'),
            'password'  => env('DB_PASSWORD_TEST'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],
    ],
];