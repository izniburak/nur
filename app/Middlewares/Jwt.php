<?php

namespace App\Middlewares;

use Nur\Auth\Jwt\JwtException;
use Nur\Http\Middleware;

class Jwt extends Middleware
{
    /**
     * This method will be triggered
     * when the middleware is called
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            auth()->jwt()->check();
        } catch (JwtException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 401);
        }

        return true;
    }
}
