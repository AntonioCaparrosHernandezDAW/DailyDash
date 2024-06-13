<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'usuarios',  //users
    ],
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'usuarios',
        ],
    ],
    'providers' => [
        /*'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],*/

         'usuarios' => [    //users
             'driver' => 'database',
             'table' => 'usuarios',
         ],
    ],
    'passwords' => [
        'usuarios' => [ //users
            'provider' => 'usuarios',   //users
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],
    'password_timeout' => 10800,
];
