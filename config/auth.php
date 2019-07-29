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
        // JWT Authentication Secret
        'secret' => env('JWT_SECRET'),

        // JWT time to live (in minutes)
        'ttl' => env('JWT_TTL', 60),

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
        'credentials' => ['email', 'password'],
        'driver'      => 'database',

        // 'credentials' => [env('BASIC_AUTH_USER'), env('BASIC_AUTH_PASS')],
        // 'driver'      => 'default',
    ],

];