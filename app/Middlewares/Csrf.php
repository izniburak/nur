<?php

namespace App\Middlewares;

use Nur\Middleware\Middleware;

class Csrf extends Middleware
{
    function handle()
    {
        if (! csrf_check(http()->post('_token')) ) {
            return uri()->redirect('/');
        }
    }
}
