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

  'env' => 'prod',

  /*
  |--------------------------------------------------------------------------
  | Application Control Panel
  |--------------------------------------------------------------------------
  |
  | This value is the endpoint name of control panel for your application.
  |
  */

  'admin' => 'admin',
  
  /*
  |--------------------------------------------------------------------------
  | Application Assets Folder
  |--------------------------------------------------------------------------
  |
  | This value is the endpoint name of assets directory for your application.
  |
  */
  
  'assets' => 'assets',

  /*
  |--------------------------------------------------------------------------
  | Application Secret Key
  |--------------------------------------------------------------------------
  |
  | This value is the secret key of your application.
  |
  */

  'key' => '',

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

  'timezone' => 'Europe/Istanbul',
  
  /*
  |--------------------------------------------------------------------------
  | Application Default HTTP Schema 
  |--------------------------------------------------------------------------
  |
  | This value is http schema of your application. 
  | If it's true, http schema will be 'https'
  |
  */
  
  'https' => false,

];
