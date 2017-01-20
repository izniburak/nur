<?php

namespace App\Middlewares;

use Nur\Middleware\Middleware;
use Nur\Http\Session;
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
