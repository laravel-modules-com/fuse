# Navigation System

This document explains how to use the array-based navigation system to inject menu items from modules.

## Overview

The navigation system allows modules to inject menu items into the main navigation menu using a structured array-based approach. The menu is divided into sections, and each module can inject its menu items into the appropriate section.

## Sections

The following sections are available:

- `navigation.dashboard`: For the dashboard link
- `navigation.settings.items`: For settings-related links
- `navigation.account.items`: For account-related links
- `navigation.modules.{module}`: For custom module links (replace {module} with your module name)

## How to Inject Menu Items

To inject menu items from a module, you need to add a `registerNavigation` method to your module's service provider.

### Example: Adding Navigation to a Service Provider

```php
namespace Modules\YourModule\Providers;

use App\Services\NavigationManager;
use Illuminate\Support\ServiceProvider;

class YourModuleServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'YourModule';

    public function boot(): void
    {
        // Other boot code...
        $this->registerNavigation();
    }

    /**
     * Register navigation items for this module
     */
    protected function registerNavigation(): void
    {
        $navigation = app(NavigationManager::class);

        // Register a navigation item with priorities
        $navigation->register(
            'navigation.modules.yourmodule',  // Section name
            [                                 // Item data
                'title' => 'Your Module',
                'route' => 'your.module.route',
                'icon' => 'your-icon',
                'permission' => 'view_your_module',
            ],
            $this->moduleName,                // Module name
            50,                               // Section priority (lower numbers appear first)
            10                                // Item priority within section (lower numbers appear first)
        );
    }
}
```

## Controlling the Order of Sections and Items

The NavigationManager allows you to control the order of sections and items by specifying priorities. Lower priority numbers appear first.

```php
// Register a navigation item with custom priorities
$navigation->register(
    'navigation.modules.yourmodule',  // Section name
    [                                 // Item data
        'title' => 'Your Module',
        'route' => 'your.module.route',
        'icon' => 'your-icon',
        'permission' => 'view_your_module',
    ],
    'YourModule',                     // Module name
    50,                               // Section priority (lower numbers appear first)
    20                                // Item priority within section (lower numbers appear first)
);
```

### Section Priority

The section priority determines the order in which sections appear in the navigation menu. Sections with lower priority numbers appear before sections with higher priority numbers.

Common section priorities:
- Dashboard: 10
- Account: 20
- Settings: 30
- Custom modules: 40+

### Item Priority

The item priority determines the order of items within a section. Items with lower priority numbers appear before items with higher priority numbers.

## Module Activation Check

The NavigationManager automatically checks if a module is enabled before displaying its menu items. This is done by passing the module name as the third parameter to the `register` method.

```php
// The navigation item will only be registered if the 'YourModule' module is enabled
$navigation->register('navigation.modules.yourmodule', [
    'title' => 'Your Module',
    'route' => 'your.module.route',
    'icon' => 'your-icon',
    'permission' => 'view_your_module',
], 'YourModule');
```

## Navigation Item Structure

Each navigation item is an array with the following structure:

```php
[
    'title' => 'Item Title',       // Required: The display text for the item
    'route' => 'route.name',       // Required: The route name
    'icon' => 'icon-name',         // Required: The icon name (from Heroicons)
    'permission' => 'permission',  // Optional: The permission required to see this item
]
```

## Navigation Components

The navigation system uses the following components behind the scenes:

- `<x-nav.link>`: For navigation links
- `<x-nav.divider>`: For section dividers

These components are automatically used by the navigation template based on the array data you provide.

## Real-World Examples

### Dashboard Item

```php
$navigation->register('navigation.dashboard', [
    'title' => 'Dashboard',
    'route' => 'dashboard',
    'icon' => 'home',
    'permission' => 'view_dashboard',
], 'Admin', 10, 10);  // High priority (10) to ensure it appears first
```

### Settings Item

```php
$navigation->register('navigation.settings.items', [
    'title' => 'System Settings',
    'route' => 'admin.settings',
    'icon' => 'wrench-screwdriver',
    'permission' => 'view_system_settings',
], 'Settings', 30, 10);  // Priority 30 for section, 10 for item (first in section)
```

### Account Item

```php
$navigation->register('navigation.account.items', [
    'title' => 'Users',
    'route' => 'admin.users.index',
    'icon' => 'users',
    'permission' => 'view_users',
], 'Users', 20, 10);  // Priority 20 for section, 10 for item (first in section)
```

### Custom Module Item

```php
$navigation->register('navigation.modules.admin', [
    'title' => 'Admin Tools',
    'route' => 'admin.tools',
    'icon' => 'wrench',
    'permission' => 'view_admin_tools',
], 'Admin', 40, 10);  // Priority 40 for section, 10 for item (first in section)
```
