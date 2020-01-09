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
        Nur\Providers\Database::class,
        Nur\Providers\Session::class,
        Nur\Providers\Cookie::class,
        Nur\Providers\Log::class,
        Nur\Providers\Hash::class,
        Nur\Providers\Validation::class,
        Nur\Providers\Cache::class,
        // Nur\Providers\Translation::class,
        // Nur\Providers\Pdox::class,
        // Nur\Providers\Html::class,

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
        'Jwt'         => Nur\Facades\Jwt::class,
        'Cookie'      => Nur\Facades\Cookie::class,
        'Session'     => Nur\Facades\Session::class,
        'Config'      => Nur\Facades\Config::class,
        'Sql'         => Nur\Facades\Sql::class,
        'DB'          => Nur\Facades\DB::class,
        'Hash'        => Nur\Facades\Hash::class,
        'Cache'       => Nur\Facades\Cache::class,
        'Log'         => Nur\Facades\Log::class,
        'Validation'  => Nur\Facades\Validation::class,
        'File'        => Nur\Facades\File::class,

    ],

];
