<?php

namespace App\Middlewares;

use Nur\Middleware\Middleware;

class Csrf extends Middleware
{
    /**
     * This method will be triggered
     * when the middleware is called
     *
     * @return mixed
     */
    function handle()
    {
        if (! csrf_check(request()->input('_token')) ) {
            return redirect('/');
        }

        return true;
    }
}
