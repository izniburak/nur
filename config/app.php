<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. (dev | test | prod)
    |
    */

    'env' => env('APP_ENV', 'prod'),

    /*
    |--------------------------------------------------------------------------
    | Application Control Panel
    |--------------------------------------------------------------------------
    |
    | This value is the endpoint name of control panel for your application.
    |
    */

    'admin' => env('ADMIN_FOLDER', 'admin'),

    /*
    |--------------------------------------------------------------------------
    | Application Assets Folder
    |--------------------------------------------------------------------------
    |
    | This value is the endpoint name of assets directory for your application.
    |
    */

    'assets' => env('ASSETS_FOLDER', 'assets'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY', ''),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => env('TIMEZONE', 'Europe/Istanbul'),

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Default HTTP Schema
    |--------------------------------------------------------------------------
    |
    | This value is http schema of your application.
    | If it's true, http schema will be 'https'
    |
    */

    'https' => env('HTTPS', false),

];
