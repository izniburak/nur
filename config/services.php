<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
        * Nur Framework Service Providers...
        */
        Nur\Providers\Auth::class,
        Nur\Providers\Blade::class,
        // Nur\Providers\Cache::class,
        Nur\Providers\Database::class,
        Nur\Providers\Hash::class,
        Nur\Providers\Mail::class,
        // Nur\Providers\Pdox::class,
        // Nur\Providers\Translation::class,

        /*
        * Application Service Providers...
        */
        App\Providers\AppServiceProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'Auth'        => Nur\Facades\Auth::class,
        // 'Cache'    => Nur\Facades\Cache::class,
        'Config'      => Nur\Facades\Config::class,
        'DB'          => Nur\Facades\DB::class,
        'Hash'        => Nur\Facades\Hash::class,
        'Jwt'         => Nur\Facades\Jwt::class,
        'Mail'        => Nur\Facades\Mail::class,
        // 'Pdox'     => Nur\Facades\Sql::class,

    ],

];
