# Frontend

This document describes the frontend components and layouts available in the Fuse application.

## Layouts

Fuse provides several layouts for different types of pages:

### App Layout

The `app.blade.php` layout is the main layout for authenticated users. It includes the navigation menu, header, and footer.

```blade
<x-layouts.app>
    <!-- Content -->
</x-layouts.app>
```

### Front Layout

The `front.blade.php` layout is used for public-facing pages. It provides a simpler layout without the admin navigation.

```blade
<x-layouts.front>
    <!-- Content -->
</x-layouts.front>
```

### Guest Layout

The `guest.blade.php` layout is used for guest pages such as login, registration, and password reset.

```blade
<x-layouts.guest>
    <!-- Content -->
</x-layouts.guest>
```

### Plain Layout

The `plain.blade.php` layout provides a minimal layout with no navigation or styling. It's useful for pages that need a custom design.

```blade
<x-layouts.plain>
    <!-- Content -->
</x-layouts.plain>
```

## Components

Fuse includes a variety of Blade components for building user interfaces:

### 2Col

The `2col.blade.php` component creates a two-column layout with left and right slots.

```blade
<x-2col>
    <x-slot name="left">
        <!-- Left column content -->
    </x-slot>
    <x-slot name="right">
        <!-- Right column content -->
    </x-slot>
</x-2col>
```

### A (Link)

The `a.blade.php` component creates a styled link.

```blade
<x-a href="{{ route('dashboard') }}">Dashboard</x-a>
```

### Alert

The `alert.blade.php` component displays an alert message.

```blade
<x-alert type="success">Your changes have been saved.</x-alert>
```

### Auth Card

The `auth-card.blade.php` component creates a card layout for authentication pages.

```blade
<x-auth-card>
    <!-- Authentication form -->
</x-auth-card>
```

### Badge

The `badge.blade.php` component displays a badge.

```blade
<x-badge type="success">Active</x-badge>
```

### Button

The `button.blade.php` component creates a styled button.

```blade
<x-button type="submit">Save</x-button>
```

### Dropdown

The dropdown component creates a dropdown menu.

```blade
<x-dropdown>
    <x-slot name="trigger">
        <button>Open Dropdown</button>
    </x-slot>
    <x-dropdown.item href="{{ route('profile') }}">Profile</x-dropdown.item>
    <x-dropdown.item href="{{ route('logout') }}">Logout</x-dropdown.item>
</x-dropdown>
```

### Form

The `form.blade.php` component creates a form with CSRF protection.

```blade
<x-form action="{{ route('users.store') }}" method="post">
    <!-- Form fields -->
    <x-button type="submit">Save</x-button>
</x-form>
```

### Modal

The `modal.blade.php` component creates a modal dialog.

```blade
<x-modal id="confirm-delete">
    <x-slot name="title">Confirm Delete</x-slot>
    <p>Are you sure you want to delete this item?</p>
    <x-slot name="footer">
        <x-button @click="$dispatch('close-modal')">Cancel</x-button>
        <x-button type="danger" @click="deleteItem">Delete</x-button>
    </x-slot>
</x-modal>
```

### Nav

The nav components create navigation elements.

```blade
<x-nav.link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
    Dashboard
</x-nav.link>
```

### Tabs

The tabs components create tabbed interfaces.

```blade
<x-tabs>
    <x-tabs.tab id="tab1" title="Tab 1" :active="true">
        <!-- Tab 1 content -->
    </x-tabs.tab>
    <x-tabs.tab id="tab2" title="Tab 2">
        <!-- Tab 2 content -->
    </x-tabs.tab>
</x-tabs>
```

## Livewire

Fuse uses Livewire for dynamic UI components. Livewire components are located in the `app/Http/Livewire` directory of each module.

### Using Livewire Components

To use a Livewire component in a Blade template:

```blade
<livewire:module-name::component-name />
```

### Creating Livewire Components

To create a new Livewire component:

```bash
php artisan make:livewire ModuleName::ComponentName
```

This will create a new Livewire component in the specified module.

## Alpine.js

Fuse uses Alpine.js for JavaScript interactivity. Alpine.js is included in the app layout and is available on all pages.

### Example Alpine.js Usage

```html
<div x-data="{ open: false }">
    <button @click="open = !open">Toggle</button>
    <div x-show="open">Content</div>
</div>
```

## Tailwind CSS

Fuse uses Tailwind CSS for styling. Tailwind classes can be used in Blade templates and components.

### Example Tailwind CSS Usage

```html
<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Card Title</h2>
    <p class="mt-2 text-gray-600 dark:text-gray-300">Card content</p>
</div>
```

## Dark Mode

Fuse supports dark mode. The dark mode can be toggled using the dark mode toggle in the navigation menu.

### Dark Mode Classes

To support dark mode, use the `dark:` variant in Tailwind classes:

```html
<div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
    This text will be dark on light background in light mode,
    and light on dark background in dark mode.
</div>
```

## Next Steps

- [Learn about testing](testing.md)
- [Explore contributing guidelines](contributing.md)
