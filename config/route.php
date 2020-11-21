<?php

return [

    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     */
    'middleware' => [
        \App\Middlewares\Csrf::class,
    ],

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     */
    'routeMiddleware' => [
        'auth' => \App\Middlewares\Auth::class,
        'auth.jwt' => \App\Middlewares\Jwt::class,
    ],

    /**
     * The application's route middleware groups.
     */
    'middlewareGroup' => [

        'web' => [

        ],

        'api' => [
            'auth.jwt'
        ],

    ],

];
