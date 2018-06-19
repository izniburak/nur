<?php 

return [

  'driver'      => env('MAIL_DRIVER', 'smtp'),
  'host'        => env('MAIL_HOST', 'smtp.localhost'),
  'port'        => env('MAIL_PORT', 587),
  'username'    => env('MAIL_USERNAME', ''),
  'password'    => env('MAIL_PASSWORD', ''),
  'encryption'  => env('MAIL_ENCRYPTION', ''),
  'charset'     => env('MAIL_CHARSET', 'utf8'),

  'from' => [
    'address' => env('MAIL_ADDRESS', 'hello@localhost'),
    'name'    => env('MAIL_NAME', 'Example'),
  ],

];
