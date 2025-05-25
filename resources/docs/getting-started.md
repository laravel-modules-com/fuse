# Getting Started with Fuse

This guide will help you get started with Fuse, a Laravel Modules Starter Kit built with the TALL stack.

## Installation

Follow these steps to install Fuse:

1. Clone the repository:
   ```bash
   git clone https://github.com/dcblogdev/laravel-admintw.git
   cd laravel-admintw
   ```

2. Copy the `.env.example` file to `.env`:
   ```bash
   cp .env.example .env
   ```

3. Set database and email settings inside the `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password

   MAIL_MAILER=smtp
   MAIL_HOST=mailhog
   MAIL_PORT=1025
   MAIL_USERNAME=null
   MAIL_PASSWORD=null
   MAIL_ENCRYPTION=null
   MAIL_FROM_ADDRESS="hello@example.com"
   MAIL_FROM_NAME="${APP_NAME}"
   ```

4. Install PHP dependencies:
   ```bash
   composer install
   ```

5. Install and build frontend assets:
   ```bash
   npm install && npm run build
   ```

6. Create a symbolic link for storage:
   ```bash
   php artisan storage:link
   ```

7. Set up the database:
   ```bash
   php artisan db:build
   ```

8. Start the development server:
   ```bash
   php artisan serve
   ```

Your application should now be running at `http://localhost:8000`.

## Configuration

### Environment Configuration

Fuse uses Laravel's environment configuration system. The main configuration file is `.env`. Here are some important configuration options:

- `APP_NAME`: The name of your application
- `APP_ENV`: The environment (local, production, etc.)
- `APP_DEBUG`: Whether to enable debug mode
- `APP_URL`: The URL of your application

### Module Configuration

Each module has its own configuration files located in the `Modules/{ModuleName}/config` directory. For example, the Settings module configuration is in `Modules/Settings/config`.

To publish a module's configuration, you can use:

```bash
php artisan vendor:publish --tag={module-name}-config
```

### System Settings

Fuse includes a System Settings interface accessible to administrators. This allows you to configure various aspects of the application through a user interface rather than editing configuration files directly.

To access System Settings:
1. Log in as an administrator
2. Navigate to Settings > System Settings

## Next Steps

Now that you have Fuse installed and configured, you can:

- [Learn about the architecture](architecture.md)
- [Explore the core features](core-features.md)
- [Understand the modules](modules/index.md)
- [Customize the navigation](navigation.md)
