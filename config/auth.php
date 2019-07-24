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

];