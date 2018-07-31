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
    Nur\Providers\Blade::class,
    Nur\Providers\Request::class,
    Nur\Providers\Response::class,
    Nur\Providers\Database::class,
    // Nur\Providers\Hash::class,
    // Nur\Providers\Html::class,
    // Nur\Providers\Cache::class,
    // Nur\Providers\Validation::class,

    /*
    * Application Service Providers...
    */

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

    'Request'     => Nur\Facades\Request::class,
    'Response'    => Nur\Facades\Response::class,
    'Uri'         => Nur\Facades\Uri::class,
    'Http'        => Nur\Facades\Http::class,
    'Cookie'      => Nur\Facades\Cookie::class,
    'Session'     => Nur\Facades\Session::class,
    'Sql'         => Nur\Facades\Sql::class,
    'DB'          => Nur\Facades\Db::class,

  ],

  /*
  |--------------------------------------------------------------------------
  | Listeners
  |--------------------------------------------------------------------------
  | The listener lists specify events that will trigger when called it.
  | This events could call with event() method and add parameters in them.
  |
  */

  'listeners' => [

    // 'SendMail'   => App\Listeners\SendMail::class,

  ],

];
