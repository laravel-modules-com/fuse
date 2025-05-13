# Project Guidelines

This document provides guidelines for development on this Laravel Modules project.

## Project Structure

This is a Laravel project that uses the Laravel Modules package to organize the code into modules. Each module has its own directory and contains its own controllers, models, views, and routes. The modules are located in the `Modules` directory at the root of the project.

## Testing Information

### Testing Framework

The project uses Pest PHP, a testing framework built on top of PHPUnit with a more expressive syntax. Pest provides a more readable and expressive way to write tests compared to traditional PHPUnit.

### Test Organization

Tests are organized by module and type:
- Feature tests: `Modules/{ModuleName}/tests/Feature/` - Test HTTP endpoints and application features
- Unit tests: `Modules/{ModuleName}/tests/Unit/` - Test individual components in isolation

### Adding New Tests

1. Tests should be placed in the appropriate module's `tests` directory:
   - `Modules/{ModuleName}/tests/Feature/` for feature tests
   - `Modules/{ModuleName}/tests/Unit/` for unit tests

2. For Pest-style tests, use the following pattern:

```php
<?php

use function Pest\expect;

test('description of the test', function () {
    // Arrange
    $data = ['example' => 'data'];

    // Act
    $result = someFunction($data);

    // Assert
    expect($result)->toBe(true);
});
```

3. For HTTP tests, use the Pest Laravel functions:

```php
<?php

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

test('it can fetch data from API', function () {
    $this->getJson(route('api.v1.example.index'))
    ->assertOk()
    ->assertJsonStructure([
        'data',
    ]);
});
```

### Example Test

Here's a simple example of a Pest test:

```php
<?php
test('example test', function () {
    expect(true)->toBeTrue();
});

test('string contains text', function () {
    expect('Hello, world!')->toContain('Hello');
});

test('array has item', function () {
    $array = ['apple', 'banana', 'orange'];
    expect($array)->toContain('banana');
});
```

## Code Style and Development Guidelines

### Code Style

The project uses Laravel Pint for code style enforcement with the Laravel preset.

The configuration is defined in `pint.json` at the root of the project. The project follows the standard Laravel coding style.

### Static Analysis

PHPStan with Larastan extension is used for static analysis at level 8:

The configuration is defined in `phpstan.neon` at the root of the project. It analyzes code in the `app/` and `Modules/` directories, excluding the Migration module, database files, and test files.

### Development Workflow

1. Create a new branch for your feature or bugfix
2. Write tests for your changes (test-driven development is encouraged)
3. Implement your changes
4. Run tests to ensure they pass
5. Run code style checks and static analysis
6. Fix any issues found by the quality checks
7. Submit a pull request

### Key Conventions

#### Code Style & Conventions

- Follow Laravel's naming conventions for all files and classes
- Always import classes instead of using fully qualified class names (FQCNs)
- Use type hints and return types for all methods
- All methods must have type hints and return types, including model scopes and relationships
- Document complex methods with PHPDoc comments
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
  
## API Responses

- When returning use a dedicated API Resource class (e.g., `IngredientResource`, `UserResource`, etc.)  unless it's a single item

Example:
```php
  public function show(Ingredient $ingredient): JsonResponse
  {
      $ingredient->load('stock', 'stockMovements');

      return new IngredientResource($ingredient);
  }
```

When returning simple success, error, or status responses (e.g. store, update, delete messages without attached model data), use simple json for consistency.
```php
  public function store(CreateIngredientRequest $request): JsonResponse
  {
      $ingredient = Ingredient::create($request->validated());

      return response()->json([
          'message' => 'Ingredient created successfully',
          'ingredient' => new IngredientResource($ingredient),
      ], Response::HTTP_CREATED);
  }
```

#### Commands and Schedules

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

#### Controllers & Requests

- Controllers should use Form Requests instead of inline validation
- Use Laravel's built-in features (like validation, middleware, etc.) instead of reinventing them

#### Models

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

#### Testing

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

#### Routing

- Routes must not use `apiResource`; write out the routes manually
- Example:
  ```php
  Route::prefix('todos')->group(function () {
      Route::get('/', [TodosController::class, 'index'])->name('api.v1.marketing.todos.index');
      Route::post('/', [TodosController::class, 'store'])->name('api.v1.marketing.todos.store');
      Route::get('/{todo}', [TodosController::class, 'show'])->name('api.v1.marketing.todos.show');
      Route::put('/{todo}', [TodosController::class, 'update'])->name('api.v1.marketing.todos.update');
      Route::delete('/{todo}', [TodosController::class, 'destroy'])->name('api.v1.marketing.todos.destroy');
  });
  ```

### Comprehensive Quality Check

To run all quality checks at once:

```bash
composer check
```

This will run linting, static analysis, type coverage, and test coverage checks.
