<?php

namespace Modules\AuditTrails\Providers;

use App\Services\NavigationManager;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AuditTrailsServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'AuditTrails';

    protected string $moduleNameLower = 'audit-trails';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerNavigation();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'database/migrations'));
    }

    /**
     * Register navigation items for this module
     */
    protected function registerNavigation(): void
    {
        $navigation = app(NavigationManager::class);

        $navigation->register('navigation.settings', [
            'title' => 'Audit Trails',
            'route' => 'admin.settings.audit-trails.index',
            'active' => 'admin.settings.audit-trails',
            'icon' => 'identification',
            'permission' => 'view_audit_trails',
        ], $this->moduleName, sectionPriority: 30, itemPriority: 0);
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
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

        $this->loadViewsFrom($sourcePath, $this->moduleNameLower);

        $componentNamespace = str_replace('/', '\\', config('modules.namespace').'\\'.$this->moduleName.'\\'.ltrim(config('modules.paths.generator.component-class.path'), config('modules.paths.app_folder', '')));
        Blade::componentNamespace($componentNamespace, $this->moduleNameLower);
    }
}
