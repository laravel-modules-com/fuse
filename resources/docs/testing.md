# Testing

This document describes the testing framework and practices used in the Fuse application.

## Overview

Fuse uses Pest PHP, a testing framework with a focus on simplicity and readability, for testing. Pest is built on top of PHPUnit and provides a more expressive syntax for writing tests.

## Running Tests

To run all tests:

```bash
php artisan test
```

To run tests for a specific module:

```bash
php artisan test --filter=ModuleNameTest
```

To run a specific test:

```bash
php artisan test --filter=testFunctionName
```

## Test Structure

Tests are organized by module, with each module having its own `tests` directory. Within each module's `tests` directory, tests are further organized by type:

- `Feature`: Tests that cover multiple units working together
- `Unit`: Tests for individual classes or methods
- `Browser`: Browser tests using Laravel Dusk (if applicable)

## Writing Tests

### Test File Naming

Test files should be named according to what they're testing, with a `Test` suffix:

- `UserTest.php`
- `AuthenticationTest.php`
- `RolePermissionTest.php`

### Basic Test Structure

A basic Pest test looks like this:

```php
<?php

use App\Models\User;

test('user can be created', function () {
    $user = User::factory()->create();
    
    expect($user)->toBeInstanceOf(User::class)
        ->and($user->name)->not->toBeEmpty();
});
```

### Testing HTTP Requests

To test HTTP requests:

```php
test('user can view dashboard', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)
        ->get('/dashboard');
    
    $response->assertStatus(200);
});
```

### Testing Livewire Components

To test Livewire components:

```php
use Livewire\Livewire;
use Modules\Users\App\Livewire\UserForm;

test('user form can create a user', function () {
    $user = User::factory()->create();
    
    Livewire::actingAs($user)
        ->test(UserForm::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('save')
        ->assertHasNoErrors();
    
    $this->assertDatabaseHas('users', [
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);
});
```

### Testing Authorization

To test authorization:

```php
test('user cannot access admin area without permission', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)
        ->get('/admin');
    
    $response->assertStatus(403);
});
```

## Test Datasets

Pest allows you to use datasets to run the same test with different inputs:

```php
dataset('users', [
    'admin' => fn() => User::factory()->create(['role' => 'admin']),
    'user' => fn() => User::factory()->create(['role' => 'user']),
]);

test('user can access their profile', function ($user) {
    $response = $this->actingAs($user)
        ->get('/profile');
    
    $response->assertStatus(200);
})->with('users');
```

## Mocking

To mock dependencies:

```php
test('service handles api failure', function () {
    $mock = $this->mock(ApiClient::class);
    $mock->shouldReceive('fetch')
        ->once()
        ->andThrow(new Exception('API error'));
    
    $service = new Service($mock);
    
    expect(fn() => $service->getData())->toThrow(Exception::class);
});
```

## Test Helpers

Fuse may include custom test helpers to simplify common testing tasks. These helpers are typically defined in the `tests/TestCase.php` file or in a separate `tests/Helpers.php` file.

Example helper:

```php
function loginAs($user)
{
    return test()->actingAs($user);
}
```

Usage:

```php
test('user can view dashboard', function () {
    $user = User::factory()->create();
    
    loginAs($user)->get('/dashboard')
        ->assertStatus(200);
});
```

## Test Database

Tests use a separate database connection to avoid affecting the development or production database. This is configured in the `phpunit.xml` file.

By default, tests use an in-memory SQLite database, but you can configure this to use any database supported by Laravel.

## Continuous Integration

Fuse may include configuration for running tests in a continuous integration (CI) environment, such as GitHub Actions, Travis CI, or CircleCI.

Example GitHub Actions workflow:

```yaml
name: Tests

on:
  push:
    branches: [ main ]
  pull_request:
    branches: [ main ]

jobs:
  tests:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v2
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.1'
        extensions: dom, curl, libxml, mbstring, zip, pcntl, pdo, sqlite, pdo_sqlite
        
    - name: Install Dependencies
      run: composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist
      
    - name: Execute tests
      run: php artisan test
```

## Next Steps

- [Explore contributing guidelines](contributing.md)
- [Return to documentation index](index.md)
