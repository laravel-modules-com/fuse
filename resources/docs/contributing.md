# Contributing to Fuse

Thank you for considering contributing to Fuse! This document outlines the guidelines for contributing to the project.

## Code of Conduct

By participating in this project, you are expected to uphold our Code of Conduct. Please report unacceptable behavior to the project maintainers.

## How to Contribute

### Reporting Bugs

If you discover a bug, please create an issue on the GitHub repository. When filing an issue, make sure to answer these questions:

1. What version of Fuse are you using?
2. What did you do?
3. What did you expect to see?
4. What did you see instead?

### Suggesting Enhancements

If you have an idea for a new feature or an enhancement to an existing feature, please create an issue on the GitHub repository. Provide as much detail as possible about your suggestion.

### Pull Requests

1. Fork the repository
2. Create a new branch for your feature or bug fix
3. Make your changes
4. Run the tests to ensure they pass
5. Submit a pull request

## Pull Request Guidelines

- **Document any change in behavior** - Make sure the README.md and any other relevant documentation are kept up-to-date.
- **One pull request per feature** - If you want to do more than one thing, send multiple pull requests.
- **Send coherent history** - Make sure each individual commit in your pull request is meaningful. If you had to make multiple intermediate commits while developing, please squash them before submitting.

## Coding Standards

### PHP

- Follow the [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standard
- Use type hints where possible
- Add PHPDoc blocks for all classes, methods, and functions
- Use strict typing by adding `declare(strict_types=1);` to the top of PHP files

Example:

```php
<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Class ExampleService
 *
 * @package App\Services
 */
class ExampleService
{
    /**
     * Do something with the given value.
     *
     * @param string $value
     * @return bool
     */
    public function doSomething(string $value): bool
    {
        // Implementation
        return true;
    }
}
```

### JavaScript

- Use ES6 syntax where possible
- Use camelCase for variable and function names
- Use PascalCase for class names
- Add JSDoc comments for all functions and classes

Example:

```javascript
/**
 * Example class for demonstration purposes.
 */
class ExampleClass {
    /**
     * Constructor for ExampleClass.
     *
     * @param {string} name - The name to use.
     */
    constructor(name) {
        this.name = name;
    }

    /**
     * Say hello to the name.
     *
     * @returns {string} A greeting message.
     */
    sayHello() {
        return `Hello, ${this.name}!`;
    }
}

// Usage
const example = new ExampleClass('World');
console.log(example.sayHello()); // Outputs: Hello, World!
```

### Blade Templates

- Use 4 spaces for indentation
- Use kebab-case for class names
- Use camelCase for variable names
- Use descriptive names for variables and components

Example:

```blade
<div class="user-profile">
    <h1 class="user-profile__title">{{ $userName }}</h1>
    
    <x-user-avatar :user="$user" class="user-profile__avatar" />
    
    <div class="user-profile__details">
        <p>Email: {{ $userEmail }}</p>
        <p>Joined: {{ $userJoinedDate->format('F j, Y') }}</p>
    </div>
</div>
```

### CSS/SCSS

- Use kebab-case for class names
- Use a consistent naming convention (e.g., BEM)
- Group related styles together
- Add comments for complex styles

Example:

```scss
// User profile component
.user-profile {
    padding: 20px;
    background-color: #f5f5f5;
    
    // Title styling
    &__title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    
    // Avatar styling
    &__avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin-bottom: 15px;
    }
    
    // Details section
    &__details {
        font-size: 14px;
        line-height: 1.5;
        
        p {
            margin-bottom: 5px;
        }
    }
}
```

## Testing

- Write tests for all new features and bug fixes
- Ensure all tests pass before submitting a pull request
- Aim for high test coverage

## Documentation

- Update the documentation for any changes to the API, behavior, or features
- Use clear and concise language
- Provide examples where appropriate

## Git Commit Messages

- Use the present tense ("Add feature" not "Added feature")
- Use the imperative mood ("Move cursor to..." not "Moves cursor to...")
- Limit the first line to 72 characters or less
- Reference issues and pull requests liberally after the first line

## Security Vulnerabilities

If you discover a security vulnerability within Fuse, please send an email to the project maintainers instead of using the issue tracker. All security vulnerabilities will be promptly addressed.

## License

By contributing to Fuse, you agree that your contributions will be licensed under the project's MIT license.

## Questions?

If you have any questions about contributing, please feel free to ask in the project's GitHub Discussions or Discord community.

## Next Steps

- [Return to documentation index](index.md)
