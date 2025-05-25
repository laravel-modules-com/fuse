# Users Module

The Users module provides user management and authentication functionality for the Fuse application.

## Overview

The Users module allows administrators to manage user accounts, handle authentication, and implement two-factor authentication. It serves as the foundation for user-related functionality in the application.

## Features

- **User Management**: Create, edit, and delete user accounts
- **User Authentication**: Login, logout, and password reset
- **Two-Factor Authentication**: Enhanced security with 2FA
- **User Profile Management**: Allow users to manage their profiles
- **User Invitations**: Invite new users to the application

## Directory Structure

```
Modules/Users/
├── app/
│   ├── Livewire/
│   ├── Mail/
│   │   └── SendInviteMail.php
│   └── Providers/
│       ├── UsersServiceProvider.php
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

### UsersServiceProvider

The `UsersServiceProvider` is responsible for registering the module's components, routes, views, translations, and navigation items.

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

The Users module registers a "Users" link in the account section of the navigation menu:

```php
$navigation->register('navigation.account.items', [
    'title' => 'Users',
    'route' => 'admin.users.index',
    'active' => 'admin.users.*',
    'icon' => 'users',
    'permission' => 'view_users',
], $this->moduleName, sectionPriority: 20, itemPriority: 0);
```

This adds a "Users" link to the account section of the navigation menu with a priority of 0, making it appear first in the section.

## Mail

### SendInviteMail

The `SendInviteMail` class is responsible for sending invitation emails to new users. It allows administrators to invite users to the application by sending them an email with a registration link.

## Routes

The Users module defines routes in the `routes/web.php` file. These routes are loaded by the `RouteServiceProvider`.

Common routes include:
- `/login`: User login
- `/logout`: User logout
- `/register`: User registration
- `/password/reset`: Password reset
- `/admin/users`: User management
- `/profile`: User profile management

## Views

The Users module provides views for user management, authentication, and profile management. These views are located in the `resources/views` directory.

## Livewire Components

The Users module includes Livewire components for dynamic UI elements in the user management and authentication interfaces.

## Two-Factor Authentication

The Users module includes support for two-factor authentication (2FA) to enhance security. When enabled, users are required to provide a second form of authentication (typically a code from an authenticator app) after entering their password.

### Enabling 2FA

Users can enable 2FA from their profile settings. The process typically involves:
1. Scanning a QR code with an authenticator app
2. Entering a verification code to confirm setup
3. Saving recovery codes for backup access

### Using 2FA

When 2FA is enabled, users will be prompted for a verification code after entering their password during login.

## User Invitations

Administrators can invite new users to the application. The invitation process typically involves:
1. Administrator enters the user's email and selects a role
2. System sends an invitation email to the user
3. User clicks the link in the email and completes registration

## Permissions

The Users module uses the following permissions:

- `view_users`: Required to view users
- `create_users`: Required to create users
- `edit_users`: Required to edit users
- `delete_users`: Required to delete users
- `invite_users`: Required to invite users

## Related Modules

- [Admin](admin.md): Provides the administrative interface
- [Roles](roles.md): Provides role and permission management
- [Settings](settings.md): Provides system settings management

## Next Steps

- [Learn about core features](../core-features.md)
- [Explore the frontend](../frontend.md)
