<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Auth
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "database", "eloquent"
    |
    */

    'driver' => 'eloquent',
    'model'  => App\Models\User::class,

    // 'driver'      => 'database',
    // 'table'       => 'users',
    // 'primary_key' => 'id',


    /*
    |--------------------------------------------------------------------------
    | JWT
    |--------------------------------------------------------------------------
    |
    | Json Web Token configurations
    |
    */

    'jwt' => [

        // Use JWT?
        'enabled' => false,

        // JWT Authentication Secret
        'secret' => env('JWT_SECRET', 'secret'),

        // JWT time to live (in minutes)
        'ttl' => env('JWT_TTL', 60),

        // JWT time to live for Refresh Token (in minutes)
        'refresh_ttl' => env('JWT_REFRESH_TTL', (60*24*30*6)),

        // JWT hashing algorithm
        'alg' => env('JWT_ALGO', 'HS256'),

        // Leeway
        'leeway' => env('JWT_LEEWAY', 0),

    ],


    /*
    |--------------------------------------------------------------------------
    | Basic Authentication
    |--------------------------------------------------------------------------
    |
    | Basic Authentication configurations.
    |
    | Supported: "default", "database"
    | If you select "database", Auth configuration at above will be used
    | for database connection.
    |
    */

    'basic' => [

        'driver'      => 'database',
        'credentials' => ['email', 'password'],

        // 'driver'      => 'default',
        // 'credentials' => [env('BASIC_AUTH_USER'), env('BASIC_AUTH_PASS')],

    ],

];
