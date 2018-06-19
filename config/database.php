<?php 

return [

  'host'      => env('DB_HOST', 'localhost'),
  'driver'    => env('DB_DRIVER', 'mysql'),
  'database'  => env('DB_DATABASE', ''),
  'username'  => env('DB_USERNAME', 'root'),
  'password'  => env('DB_PASSWORD', ''),
  'charset'   => env('DB_CHARSET', 'utf8'),
  'collation' => env('DB_COLLATION', 'utf8_general_ci'),
  'prefix'    => env('DB_PREFIX', ''),

];
