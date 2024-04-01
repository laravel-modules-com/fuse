<?php

namespace Modules\Settings\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function map(): void
    {
        Route::middleware('web')->group(module_path('Settings', '/routes/web.php'));
    }
}
