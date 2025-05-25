<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\NavigationManager;
use Illuminate\Support\ServiceProvider;

class NavigationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(NavigationManager::class);
    }

    public function boot(): void {}
}
