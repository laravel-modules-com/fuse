# Settings Module

The Settings module provides system settings management functionality for the Fuse application.

## Overview

The Settings module allows administrators to configure various aspects of the application through a user interface rather than editing configuration files directly. It provides a centralized location for managing application settings.

## Features

- **System Settings Management**: Configure application-wide settings
- **Key-Value Storage**: Store settings as key-value pairs
- **Settings UI**: User interface for managing settings
- **Settings API**: Programmatic access to settings

## Directory Structure

```
Modules/Settings/
├── app/
│   ├── Livewire/
│   ├── Models/
│   │   └── Setting.php
│   └── Providers/
│       ├── SettingsServiceProvider.php
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

### SettingsServiceProvider

The `SettingsServiceProvider` is responsible for registering the module's components, routes, views, translations, and navigation items.

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

The Settings module registers a "System Settings" link in the settings section of the navigation menu:

```php
$navigation->register('navigation.settings', [
    'title' => 'System Settings',
    'route' => 'admin.system-settings',
    'active' => 'admin.system-settings',
    'icon' => 'wrench-screwdriver',
    'permission' => 'view_system_settings',
], $this->moduleName, sectionPriority: 30, itemPriority: 3);
```

This adds a "System Settings" link to the settings section of the navigation menu with a priority of 3, making it appear third in the section.

## Models

### Setting

The `Setting` model represents a system setting in the database. It uses the HasUuid trait for UUID generation.

Key attributes:
- `key`: The setting key
- `value`: The setting value

## Routes

The Settings module defines routes in the `routes/web.php` file. These routes are loaded by the `RouteServiceProvider`.

## Views

The Settings module provides views for managing system settings. These views are located in the `resources/views` directory.

## Livewire Components

The Settings module includes Livewire components for dynamic UI elements in the settings management interface.

## Usage

### Accessing Settings

To access a setting programmatically:

```php
use Modules\Settings\Models\Setting;

// Get a setting value
$value = Setting::where('key', 'site_name')->value('value');

// Or using a helper function (if available)
$value = setting('site_name');
```

### Updating Settings

To update a setting programmatically:

```php
use Modules\Settings\Models\Setting;

// Update a setting
$setting = Setting::where('key', 'site_name')->first();
if ($setting) {
    $setting->update(['value' => 'New Site Name']);
}

// Or using a helper function (if available)
setting(['site_name' => 'New Site Name']);
```

### Managing Settings via UI

Administrators can manage settings through the admin interface by navigating to Settings > System Settings.

## Common Settings

The Settings module may include the following common settings:

- `site_name`: The name of the site
- `site_description`: The description of the site
- `site_logo`: The logo of the site
- `email_from_address`: The email address used for sending emails
- `email_from_name`: The name used for sending emails
- `allowed_login_ips`: IP addresses allowed for login (when office login only is enabled)

## Permissions

The Settings module uses the following permissions:

- `view_system_settings`: Required to view system settings
- `edit_system_settings`: Required to edit system settings

## Related Modules

- [Admin](admin.md): Provides the administrative interface
- [Users](users.md): Provides user management functionality
- [Roles](roles.md): Provides role and permission management

## Next Steps

- [Learn about the Users module](users.md)
