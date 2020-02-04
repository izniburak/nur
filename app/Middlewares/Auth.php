<?php

namespace App\Middlewares;

use Nur\Middleware\Middleware;

class Auth extends Middleware
{
    /**
     * This method will be triggered
     * when the middleware is called
     *
     * @return mixed
     */
    public function handle()
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        return true;
    }
}
