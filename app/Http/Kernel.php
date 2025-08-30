<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        'auth.bearer' => \App\Http\Middleware\BearerAuth::class,
        'role' => \App\Http\Middleware\CheckRole::class,
    ];
}
