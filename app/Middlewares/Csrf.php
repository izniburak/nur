<?php

namespace App\Middlewares;

use Nur\Exception\BadRequestHttpException;
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
        if (! in_array(request()->method(), ['HEAD', 'GET', 'OPTIONS'])) {
            $token = request()->input('_token') ?: request()->header('X-CSRF-TOKEN');
            if (! csrf_check($token)) {
                throw new BadRequestHttpException;
            }
        }

        return true;
    }
}
