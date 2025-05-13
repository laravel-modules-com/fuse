# Fuse Development Guidelines

## Introduction
This document outlines the coding standards, best practices, and development guidelines for the Fuse project. These guidelines are designed to ensure consistency, maintainability, and quality across the codebase.

## Table of Contents
1. [Code Style](#code-style)
2. [Laravel 12 Best Practices](#laravel-12-best-practices)
3. [Modular Architecture](#modular-architecture)
4. [Livewire Components](#livewire-components)
5. [Test-Driven Development (TDD)](#test-driven-development-tdd)
6. [Frontend Development](#frontend-development)

## Code Style

### PHP Code Style
- Follow the Laravel coding style as defined in the [Laravel documentation](https://laravel.com/docs/master/contributions#coding-style).
- Use Laravel Pint for code formatting with the Laravel preset.
- Use strict typing with `declare(strict_types=1)` at the top of PHP files.
- Use proper type hints for method parameters and return types.
- Use PHPDoc blocks for properties, methods, and functions with proper type annotations.
- Always import classes instead of using fully qualified class names (FQCNs)
- All methods must have type hints and return types, including model scopes and relationships
- Use camelCase for variables and methods, PascalCase for classes, and snake_case for database fields.
- Keep methods small and focused on a single responsibility.
- Use meaningful variable and method names that describe their purpose.
- PHPDoc types should use generics for collections and arrays
- Example:
  ```php
  /**
   * Get the user's orders.
   *
   * @return HasMany<Order>
   */
  public function orders(): HasMany
  {
      return $this->hasMany(Order::class);
  }
  ```
### API Responses
- When using API routes use single API routes don't use ApiResource for routing
- Responses should use Resource classes

### Static Analysis
- Maintain a high level of code quality with PHPStan (level 8).
- Fix static analysis issues before committing code.
- Use IDE helpers for better code completion and static analysis.

## Laravel 12 Best Practices

### General
- Follow the Laravel documentation for the latest best practices.
- Use Laravel's built-in features instead of reinventing the wheel.
- Use dependency injection instead of facades when possible for better testability.
- Use environment variables for configuration.
- Use Laravel's validation features for input validation in form requests, don't do inline validation unless using a Livewire class
- Use permissions checks via Spatie Permissions package (installed) features for access control.

### Database
- Use migrations for database schema changes.
- Use UUID as the primary key with a name of id
- for relations use foreignUuid
- don't use enum collumn prefer to store as string and use Enum classes
- Use factories and seeders for test data.
- Use Eloquent relationships to define relationships between models.
- Use query scopes for common query patterns. Use laravel 12 scope attributes
- Use database transactions for operations that need to be atomic.

#### Seeders
In seeders create CRUD permissions and specify the module like:
```php
Permission::firstOrCreate(['name' => 'view_users', 'label' => 'View Users', 'module' => 'Users']);
Permission::firstOrCreate(['name' => 'view_users_profiles', 'label' => 'View Users Profiles', 'module' => 'Users']);
Permission::firstOrCreate(['name' => 'view_users_activity', 'label' => 'View Users Activity', 'module' => 'Users']);
Permission::firstOrCreate(['name' => 'add_users', 'label' => 'Add Users', 'module' => 'Users']);
Permission::firstOrCreate(['name' => 'edit_users', 'label' => 'Edit Users', 'module' => 'Users']);
Permission::firstOrCreate(['name' => 'edit_own_account', 'label' => 'Edit Own Account', 'module' => 'Users']);
Permission::firstOrCreate(['name' => 'delete_users', 'label' => 'Delete Users', 'module' => 'Users']);
```

### Security
- Use Laravel's authentication and authorization features.
- Validate all user input.
- Use CSRF protection for forms.
- Use Laravel's encryption and hashing features.
- Implement proper error handling and logging.

## Modular Architecture

### Module Structure
- Each module should be self-contained with its own:
  - app
      - Controllers
      - Models
      - Providers
  - config
  - database
  - resources
      - views
  - routes
  - tests
- Follow the standard Laravel directory structure within each module.
- Use namespaces that reflect the module structure (e.g., `Modules\Admin\Controllers`).

### Commands and Schedules

- Commands should be placed in the Modules `app/Console` directory
- Commands should be registered in the module's service provider, note commands should be imported with the `use` statement instead of using FQCNs
- 
  ```php
  
  use Modules\Marketing\Console\ExampleCommand;
  
  public function register()
  {
      $this->commands([
          ExampleCommand::class,
      ]);
  }
  ```
  - Commands can be scheduled from the module service provider:
  ```php
  protected function registerCommandSchedules(): void
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

            $schedule->command(ExampleCommand::class)->everyMinute();
        });
    }
  ```

### Module Communication
- Use events and listeners for inter-module communication.
- Use service providers for registering module components.
- Use interfaces and dependency injection for loose coupling between modules.

### Module Development
- Create new modules using the module generator command.
- Keep modules focused on a specific domain or feature set.
- Document module dependencies and requirements.

### Models
- Models must create a `newFactory` method when using `HasFactory`
- Models should use `/** @use HasFactory<ModelNameFactory> */` when using `use HasFactory;`
- Models relationships must include docblocks for @param and @return types including generics
- Fillables must include `@var array<int, string>`
- Example:
  ```php
  /** @use HasFactory<TodoFactory> */
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
      'title',
      'description',
      'completed',
  ];

  protected static function newFactory(): TodoFactory
  {
      return TodoFactory::new();
  }
  ```

## Livewire Components

### Component Structure
- Use a single responsibility approach for Livewire components.
- Place Livewire components in the `app/Livewire` directory of the module.
- Use PascalCase for component class names (e.g., `NotificationsMenu`).
- Use kebab-case for component view names (e.g., `notifications-menu.blade.php`).
- Place component views in the `resources/views/livewire` directory of the module.

### Component Implementation
- Use proper type hints and PHPDoc annotations for properties and methods.
- Use the `mount()` method for component initialization.
- Use computed properties for derived data.
- Use actions for handling user interactions.
- Use validation for form inputs.
- Use proper error handling and feedback.

### Component Testing
- Test each component in isolation.
- Test component state and actions.
- Use Livewire's testing utilities for component testing.
- Test edge cases and error conditions.
- Tests must use Pest style, not PHPUnit style
- Tests don't need to run `RefreshDatabase`
- Tests must use `beforeEach` when there are multiple tests that need the same setup
- Don't use multiple $response variables when you can chain methods 
- Don't use variables if not needed
- use $this->getJson instead of getJson helpers same for PostJson, PatchJson and DeleteJson
- Example:
  ```php
  beforeEach(function () {
      $this->authenticate();
  });

  test('user can view their profile', function () {
      $this
        ->getJson(route('api.v1.users.profile'))
        ->assertOk();
  });
  ```

## Test-Driven Development (TDD)

### Testing Approach
- Use Pest PHP for testing.
- Organize tests to mirror the application structure.
- Use descriptive test names that explain what is being tested.
- Use factories and seeders for test data.
- Use database transactions for test isolation.

### Test Types
- Unit Tests: Test individual classes and methods in isolation.
- Feature Tests: Test the integration of multiple components.

### Test Coverage
- Aim for high test coverage, especially for critical paths.
- Test edge cases and error conditions.
- Test both happy and unhappy paths.
- Test authorization and validation.

## Frontend Development

### Blade Templates
- Use Blade components for reusable UI elements.
- Use Blade layouts for consistent page structure.
- Use translation functions for internationalization.
- Use proper indentation and formatting for readability.

### CSS and JavaScript
- Use Tailwind CSS for styling.
- Use Alpine.js for frontend interactivity.
- Use Laravel Vite for asset compilation.
- Follow the BEM (Block Element Modifier) methodology for custom CSS.
- Use ES6+ features for JavaScript.

### Accessibility
- Use semantic HTML elements.
- Use ARIA attributes for enhanced accessibility.
- Ensure proper color contrast for text.
- Ensure keyboard navigation works correctly.
- Test with screen readers and other assistive technologies.
