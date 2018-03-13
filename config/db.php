<?php

return [
    'default' => [
        'driver' => getenv('DATABASE_DRIVER'),
        'host' => getenv('DATABASE_HOST'),
        'user' => getenv('DATABASE_USER'),
        'password' => getenv('DATABASE_PASS'),
        'database' => getenv('DATABASE_NAME'),
        'exceptions' => true,
        'charset' => 'utf8'
    ]
];