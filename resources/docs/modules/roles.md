# Roles Module

The Roles module provides role and permission management functionality for the Fuse application.

## Overview

The Roles module allows administrators to create and manage roles and permissions for users in the application. It uses the Spatie Laravel Permission package to implement role-based access control.

## Features

- **Role Management**: Create, edit, and delete roles
- **Permission Management**: Assign permissions to roles
- **User Role Assignment**: Assign roles to users
- **Permission-based Access Control**: Control access to features based on permissions

## Directory Structure

```
Modules/Roles/
├── app/
│   ├── Livewire/
│   ├── Models/
│   │   ├── Permission.php
│   │   └── Role.php
│   └── Providers/
│       ├── RolesServiceProvider.php
│       └── RouteServiceProvider.php
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
├── routes/
├── tests/
├── composer.json
└── module.json
```

## Service Providers

### RolesServiceProvider

The `RolesServiceProvider` is responsible for registering the module's components, routes, views, translations, and navigation items.

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

The Roles module registers a "Roles" link in the settings section of the navigation menu:

```php
$navigation->register('navigation.settings', [
    'title' => 'Roles',
    'route' => 'admin.settings.roles.index',
    'active' => 'admin.settings.roles.*',
    'icon' => 'archive-box',
    'permission' => 'view_roles',
], $this->moduleName, sectionPriority: 30, itemPriority: 1);
```

This adds a "Roles" link to the settings section of the navigation menu with a priority of 1, making it appear second in the section.

## Models

### Role

The `Role` model extends Spatie's Role model and represents a role in the application. It uses the HasUuid trait for UUID generation.

Key attributes:
- `id`: UUID of the role
- `name`: Name of the role
- `guard_name`: Guard name for the role

### Permission

The `Permission` model extends Spatie's Permission model and represents a permission in the application. It uses the HasUuid trait for UUID generation.

Key attributes:
- `id`: UUID of the permission
- `name`: Name of the permission
- `label`: Human-readable label for the permission
- `module`: The module that the permission belongs to
- `guard_name`: Guard name for the permission

## Routes

The Roles module defines routes in the `routes/web.php` file. These routes are loaded by the `RouteServiceProvider`.

## Views

The Roles module provides views for managing roles and permissions. These views are located in the `resources/views` directory.

## Livewire Components

The Roles module includes Livewire components for dynamic UI elements in the role and permission management interfaces.

## Usage

### Creating a Role

Administrators can create roles through the admin interface by navigating to Settings > Roles.

### Assigning Permissions to a Role

Permissions can be assigned to roles through the admin interface.

### Checking Permissions

To check if a user has a permission:

```php
if (auth()->user()->can('view_roles')) {
    // User has permission to view roles
}
```

### Checking Roles

To check if a user has a role:

```php
if (auth()->user()->hasRole('admin')) {
    // User has the admin role
}
```

## Permissions

The Roles module uses the following permissions:

- `view_roles`: Required to view roles
- `create_roles`: Required to create roles
- `edit_roles`: Required to edit roles
- `delete_roles`: Required to delete roles

## Related Modules

- [Admin](admin.md): Provides the administrative interface
- [Users](users.md): Provides user management functionality
- [Settings](settings.md): Provides system settings management

## Next Steps

- [Learn about the Settings module](settings.md)
- [Learn about the Users module](users.md)
