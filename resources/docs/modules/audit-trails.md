# AuditTrails Module

The AuditTrails module provides functionality for tracking user actions and changes to models in the Fuse application.

## Overview

The AuditTrails module allows administrators to track and review user activities within the application. It records actions such as creating, updating, and deleting records, as well as other significant user interactions.

## Features

- **Activity Logging**: Records user actions and model changes
- **User Action Tracking**: Associates actions with specific users
- **Audit Log Viewer**: Interface for administrators to review audit logs
- **Filtering and Searching**: Tools to filter and search audit logs

## Directory Structure

```
Modules/AuditTrails/
├── app/
│   ├── Livewire/
│   ├── Models/
│   │   └── AuditTrail.php
│   └── Providers/
│       ├── AuditTrailsServiceProvider.php
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

### AuditTrailsServiceProvider

The `AuditTrailsServiceProvider` is responsible for registering the module's components, routes, views, translations, and navigation items.

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

The AuditTrails module registers an "Audit Trails" link in the settings section of the navigation menu:

```php
$navigation->register('navigation.settings', [
    'title' => 'Audit Trails',
    'route' => 'admin.settings.audit-trails.index',
    'active' => 'admin.settings.audit-trails',
    'icon' => 'identification',
    'permission' => 'view_audit_trails',
], $this->moduleName, sectionPriority: 30, itemPriority: 0);
```

This adds an "Audit Trails" link to the settings section of the navigation menu.

## Models

### AuditTrail

The `AuditTrail` model represents an audit trail entry in the database. It has the following attributes:

- `user_id`: The ID of the user who performed the action
- `title`: The title or description of the action
- `link`: A link to the related resource
- `reference_id`: The ID of the related resource
- `section`: The section of the application where the action occurred
- `type`: The type of action (create, update, delete, etc.)

The model uses the following traits:
- `HasFactory`: For model factories
- `HasUuid`: For UUID generation
- `SoftDeletes`: For soft deletes

Relationships:
- `user()`: Belongs to a User

## Routes

The AuditTrails module defines routes in the `routes/web.php` file. These routes are loaded by the `RouteServiceProvider`.

## Views

The AuditTrails module provides views for displaying audit logs. These views are located in the `resources/views` directory.

## Livewire Components

The AuditTrails module includes Livewire components for dynamic UI elements in the audit log viewer.

## Usage

### Recording an Audit Trail

To record an audit trail entry, you can use the `AuditTrail` model:

```php
use Modules\AuditTrails\Models\AuditTrail;

AuditTrail::create([
    'user_id' => auth()->id(),
    'title' => 'Created a new user',
    'link' => route('admin.users.show', $user->id),
    'reference_id' => $user->id,
    'section' => 'Users',
    'type' => 'create',
]);
```

### Viewing Audit Trails

Administrators can view audit trails by navigating to Settings > Audit Trails in the admin interface.

## Permissions

The AuditTrails module uses the following permissions:

- `view_audit_trails`: Required to view audit trails

## Related Modules

- [Admin](admin.md): Provides the administrative interface
- [Users](users.md): Provides user management functionality
- [Roles](roles.md): Provides role and permission management

## Next Steps

- [Learn about the Roles module](roles.md)
- [Learn about the Settings module](settings.md)
- [Learn about the Users module](users.md)
