<?php

namespace App\Middlewares;

use Nur\Middleware\Middleware;

class Auth extends Middleware
{
    function handle()
    {
        if (! session()->hasKey('uid')) {
            return uri()->redirect('login');
        }

        return;
    }
}
