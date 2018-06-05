<?php

namespace App\Middlewares;

use Nur\Middleware\Middleware;

class Auth extends Middleware
{
    function isLogin()
    {
        if(session('uid') == false)
            return uri()->redirect('user/login');

        return;
    }
}
