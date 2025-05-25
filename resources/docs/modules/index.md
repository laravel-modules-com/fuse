# Modules

Fuse is built with a modular architecture, where each module is a self-contained unit that can be enabled or disabled independently. This document provides an overview of the available modules.

## Available Modules

Fuse includes the following modules:

### [Admin](admin.md)

The Admin module provides the core administration functionality for the application. It includes:

- Dashboard
- Admin layouts and components
- Help menu
- Admin-specific middleware

### [AuditTrails](audit-trails.md)

The AuditTrails module tracks changes to models and user actions in the system. It includes:

- Activity logging
- User action tracking
- Audit log viewer

### [Roles](roles.md)

The Roles module manages user roles and permissions. It includes:

- Role management
- Permission management
- Role assignment to users
- Permission-based access control

### [Settings](settings.md)

The Settings module manages application settings. It includes:

- System settings
- User settings
- Settings management interface

### [Users](users.md)

The Users module manages user accounts and authentication. It includes:

- User management
- User authentication
- Two-factor authentication
- User profile management

## Module Structure

Each module follows a consistent structure. For more details on the module structure, see the [Architecture](../architecture.md#module-structure) documentation.

## Enabling and Disabling Modules

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

## Creating a New Module

To create a new module, you can use the following Artisan command:

```bash
php artisan module:make ModuleName
```

This will create a new module with the standard directory structure.

## Module Dependencies

Modules can depend on other modules. Dependencies are managed through the `module.json` file in the module root directory.

Example:
```json
{
    "name": "ModuleName",
    "alias": "modulename",
    "description": "Module description",
    "keywords": [],
    "priority": 0,
    "providers": [
        "Modules\\ModuleName\\Providers\\ModuleNameServiceProvider"
    ],
    "aliases": {},
    "files": [],
    "requires": [
        "Users",
        "Roles"
    ]
}
```

In this example, the module depends on the Users and Roles modules.

## Next Steps

- [Learn about the Admin module](admin.md)
- [Learn about the AuditTrails module](audit-trails.md)
- [Learn about the Roles module](roles.md)
- [Learn about the Settings module](settings.md)
- [Learn about the Users module](users.md)
