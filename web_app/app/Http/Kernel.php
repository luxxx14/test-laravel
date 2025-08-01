<?php

namespace App\Http;

use App\Http\Middleware\CheckApiKey;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        // другие глобальные middleware
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'api_key' => CheckApiKey::class,  // Регистрируем наше middleware
    ];
}
