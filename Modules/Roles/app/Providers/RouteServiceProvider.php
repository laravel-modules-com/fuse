<?php

namespace Modules\Roles\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function map(): void
    {
        Route::middleware('web')->group(module_path('Roles', '/routes/web.php'));
    }
}
