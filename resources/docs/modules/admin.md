# Admin Module

The Admin module provides the core administration functionality for the Fuse application.

## Overview

The Admin module serves as the foundation for the administrative interface of the application. It provides the dashboard, admin layouts, components, and middleware necessary for the administration area.

## Features

- **Dashboard**: A central hub for administrators to view key information and access administrative functions
- **Admin Layouts**: Reusable layouts for admin pages
- **Help Menu**: Context-sensitive help for administrators
- **Admin-specific Middleware**: Middleware for securing admin routes

## Directory Structure

```
Modules/Admin/
├── app/
│   ├── Actions/
│   ├── Http/
│   ├── Livewire/
│   ├── Models/
│   ├── Notifications/
│   ├── Providers/
│   │   ├── AdminServiceProvider.php
│   │   └── RouteServiceProvider.php
│   └── Rules/
├── config/
├── database/
├── resources/
│   └── views/
├── routes/
├── tests/
├── composer.json
└── module.json
```

## Service Providers

### AdminServiceProvider

The `AdminServiceProvider` is responsible for registering the module's components, routes, views, translations, and navigation items.

Key methods:

- `boot()`: Bootstraps the module
- `registerNavigation()`: Registers navigation items for the module
- `register()`: Registers the RouteServiceProvider
- `registerCommands()`: Registers Artisan commands
- `registerCommandSchedules()`: Registers command schedules
- `registerTranslations()`: Registers translations
- `registerConfig()`: Registers configuration
- `registerViews()`: Registers views

### RouteServiceProvider

The `RouteServiceProvider` is responsible for loading the module's routes.

## Navigation

The Admin module registers the dashboard link in the navigation menu:

```php
$navigation->register('navigation.dashboard', [
    'title' => 'Dashboard',
    'route' => 'dashboard',
    'active' => 'dashboard',
    'icon' => 'home',
    'permission' => 'view_dashboard',
], $this->moduleName, sectionPriority: 10, itemPriority: 0);
```

This adds a "Dashboard" link to the navigation menu with the highest priority (10) to ensure it appears first.

## Routes

The Admin module defines routes in the `routes/web.php` file. These routes are loaded by the `RouteServiceProvider`.

## Views

The Admin module provides views for the dashboard and other administrative pages. These views are located in the `resources/views` directory.

## Middleware

The Admin module may include middleware for securing admin routes and performing other administrative functions.

## Models

The Admin module may include models for administrative data.

## Livewire Components

The Admin module includes Livewire components for dynamic UI elements in the administrative interface.

## Usage

### Accessing the Dashboard

The dashboard is the main entry point for administrators. It can be accessed at the `/dashboard` route.

### Using Admin Layouts

Admin layouts can be used in Blade templates:

```blade
<x-admin::layouts.admin>
    <!-- Content -->
</x-admin::layouts.admin>
```

### Using Admin Components

Admin components can be used in Blade templates:

```blade
<x-admin::component-name />
```

## Permissions

The Admin module uses the following permissions:

- `view_dashboard`: Required to view the dashboard

## Related Modules

- [Users](users.md): Provides user management functionality
- [Roles](roles.md): Provides role and permission management
- [Settings](settings.md): Provides system settings management

## Next Steps

- [Learn about the AuditTrails module](audit-trails.md)
- [Learn about the Roles module](roles.md)
- [Learn about the Settings module](settings.md)
- [Learn about the Users module](users.md)
