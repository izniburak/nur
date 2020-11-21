<?php

namespace App\Middlewares;

use Nur\Exception\BadRequestHttpException;
use Nur\Http\Middleware;
use Nur\Http\Request;

class Csrf extends Middleware
{
    /**
     * This method will be triggered
     * when the middleware is called
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function handle(Request $request)
    {
        if (!in_array($request->method(), ['HEAD', 'GET', 'OPTIONS'])) {
            $token = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');
            if (!csrf_check($token)) {
                throw new BadRequestHttpException;
            }
        }

        return true;
    }
}
