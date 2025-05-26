<?php

declare(strict_types=1);

namespace Modules\{Module}\Providers;

use App\Services\NavigationManager;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class {Module}ServiceProvider extends ServiceProvider
{
    protected string $moduleName = '{Module}';
    protected string $moduleNameLower = '{module}';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerNavigation();
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'database/migrations'));
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }

    protected function registerNavigation(): void
    {
        $navigation = app(NavigationManager::class);

        $navigation->register('navigation.', [
            'title' => '{Module }',
            'route' => 'admin.{module-}.index',
            'active' => 'admin.{module-}.*',
            'icon' => 'users',
            'permission' => 'view_{module_}',
        ], $this->moduleName, sectionPriority: 10, itemPriority: 0);
    }

    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void
    {
        // $this->commands([]);
    }

    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules(): void
    {
        // $this->app->booted(function () {
        //     $schedule = $this->app->make(Schedule::class);
        //     $schedule->command('inspire')->hourly();
        // });
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = config('modules.paths.generator.lang.path');
        $this->loadTranslationsFrom(module_path($this->moduleName, $langPath), $this->moduleNameLower);
        $this->loadJsonTranslationsFrom(module_path($this->moduleName, $langPath));
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $this->publishes([module_path($this->moduleName, 'config/config.php') => config_path($this->moduleNameLower.'.php')], 'config');
        $this->mergeConfigFrom(module_path($this->moduleName, 'config/config.php'), $this->moduleNameLower);
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/'.$this->moduleNameLower);
        $sourcePath = module_path($this->moduleName, 'resources/views');

        $this->publishes([$sourcePath => $viewPath], ['views', $this->moduleNameLower.'-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);

        $componentNamespace = str_replace('/', '\\', config('modules.namespace').'\\'.$this->moduleName.'\\'.config('modules.paths.generator.component-class.path'));
        Blade::componentNamespace($componentNamespace, $this->moduleNameLower);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (config('view.paths') as $path) {
            if (is_dir($path.'/modules/'.$this->moduleNameLower)) {
                $paths[] = $path.'/modules/'.$this->moduleNameLower;
            }
        }

        return $paths;
    }
}
