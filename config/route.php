<?php

return [

    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     */
    'middleware' => [
        // \Nur\Http\Middleware\CorsMiddleware::class,
    ],

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     */
    'routeMiddleware' => [
        'auth' => \Nur\Http\Middleware\AuthMiddleware::class,
        'auth.jwt' => \Nur\Http\Middleware\JwtMiddleware::class,
    ],

    /**
     * The application's route middleware groups.
     */
    'middlewareGroup' => [

        'web' => [
            // \Nur\Http\Middleware\CsrfMiddleware::class,
        ],

        'api' => [
            'auth.jwt',
        ],

    ],

];
