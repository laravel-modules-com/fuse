<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\NavigationManager;
use Illuminate\Support\ServiceProvider;

class DocumentationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerNavigation();
    }

    /**
     * Register navigation items for documentation
     */
    protected function registerNavigation(): void
    {
        $navigation = app(NavigationManager::class);

        // Register documentation link in the navigation menu
        $navigation->register('navigation.modules.documentation', [
            'title' => 'Documentation',
            'route' => 'documentation.index',
            'active' => 'documentation.*',
            'icon' => 'book-open',
            'permission' => null, // No permission required to view documentation
        ], null, sectionPriority: 40, itemPriority: 0);
    }
}
