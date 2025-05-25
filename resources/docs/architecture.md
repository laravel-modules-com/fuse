# Fuse Architecture

This document describes the architecture of Fuse, a Laravel Modules Starter Kit built with the TALL stack.

## Overview

Fuse is built on top of Laravel and uses a modular architecture to organize code into separate, reusable modules. Each module is a self-contained unit that can be enabled or disabled independently.

The project follows the TALL stack:
- **T**ailwind CSS for styling
- **A**lpine.js for JavaScript interactivity
- **L**aravel for the backend framework
- **L**ivewire for dynamic UI components

## Module Structure

Each module in Fuse follows a consistent structure:

```
Modules/ModuleName/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Livewire/
│   │   └── Middleware/
│   ├── Models/
│   ├── Providers/
│   │   ├── ModuleNameServiceProvider.php
│   │   └── RouteServiceProvider.php
│   └── Services/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   └── livewire/
│   └── lang/
├── routes/
│   ├── api.php
│   └── web.php
├── tests/
├── composer.json
└── module.json
```

### Key Directories and Files

- **app/**: Contains the module's PHP code
  - **Http/**: Controllers, Livewire components, and middleware
  - **Models/**: Eloquent models
  - **Providers/**: Service providers for the module
  - **Services/**: Service classes for business logic

- **config/**: Module-specific configuration files

- **database/**: Database-related files
  - **migrations/**: Database migrations
  - **seeders/**: Database seeders
  - **factories/**: Model factories for testing

- **resources/**: Frontend resources
  - **views/**: Blade templates
  - **lang/**: Localization files

- **routes/**: Route definitions
  - **web.php**: Web routes
  - **api.php**: API routes

- **tests/**: Module-specific tests

- **composer.json**: Composer dependencies for the module

- **module.json**: Module metadata and configuration

## Service Providers

Each module has at least two service providers:

### ModuleNameServiceProvider

The main service provider for the module, responsible for:
- Registering the module's routes
- Loading views, translations, and migrations
- Registering the module's components
- Registering the module's navigation items
- Binding services to the container

Example:

```php
namespace Modules\ModuleName\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleNameServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'ModuleName';
    
    public function boot(): void
    {
        $this->registerConfig();
        $this->registerViews();
        $this->registerNavigationItems();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'database/migrations'));
    }
    
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }
    
    protected function registerConfig(): void
    {
        $this->publishes([
            module_path($this->moduleName, 'config/config.php') => config_path($this->moduleName.'.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'config/config.php'), $this->moduleName
        );
    }
    
    protected function registerViews(): void
    {
        $this->loadViewsFrom(module_path($this->moduleName, 'resources/views'), $this->moduleName);
    }
    
    protected function registerNavigationItems(): void
    {
        // Register navigation items for this module
    }
}
```

### RouteServiceProvider

Responsible for loading the module's routes:

```php
namespace Modules\ModuleName\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $moduleNamespace = 'Modules\ModuleName\Http\Controllers';
    
    public function boot(): void
    {
        parent::boot();
    }
    
    public function map(): void
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }
    
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->group(module_path('ModuleName', 'routes/web.php'));
    }
    
    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('ModuleName', 'routes/api.php'));
    }
}
```

## Module Activation

Modules can be enabled or disabled through the `modules_statuses.json` file in the project root. This file contains a JSON object with module names as keys and boolean values indicating whether the module is enabled.

Example:
```json
{
    "Admin": true,
    "AuditTrails": true,
    "Roles": true,
    "Settings": true,
    "Users": true
}
```

## Dependency Injection

Fuse uses Laravel's dependency injection container to manage dependencies between modules. Services can be bound to the container in a module's service provider and then injected into controllers, Livewire components, or other services.

## Event System

Modules can communicate with each other through Laravel's event system. A module can fire events that other modules can listen for and respond to.

## Next Steps

- [Explore the core features](core-features.md)
- [Learn about the modules](modules/index.md)
- [Understand the navigation system](navigation.md)
