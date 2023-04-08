<?php

// config for Laraflow/BackpackApiLog
return [
    'table' => 'api_logs',
    'model' => \Laraflow\BackpackApiLog\Models\ApiLog::class,
    'route' => '/api-log',
    'enabled' => env('BACKPACK_API_LOG', false),
    'logs' => [
        //which methods should be logged
        'method' => [
            'GET' => 'GET',
            'POST' => 'POST',
            'PUT' => 'PUT',
            'PATCH' => 'PATCH',
            'DELETE' => 'DELETE',
            'OPTION' => 'OPTION',
        ],
        //which api endpoints should be logged
        'host' => [
            '*' //means all
            //
        ],
        //which api http status code should be logged
        'code' => [
            '200' => '200',
            '400' => '400',
            '500' => '500',
            '404' => '404',
            '422' => '422',
            '419' => '419',
        ],
    ],
    'exclude' => [
        // host name only that need to be excluded
    ]
];
