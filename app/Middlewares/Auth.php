<?php

namespace App\Middlewares;

use Mubu\Middleware\Middleware;
use Mubu\Http\Session;
use Uri;

class Auth extends Middleware
{
  function isLogin()
  {
    if(session::get('uid') == false)
      return uri::redirect('user/login');

    return;
  }
}
