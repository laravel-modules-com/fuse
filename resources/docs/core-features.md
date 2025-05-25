# Core Features

This document describes the core features of the Fuse application.

## Authentication

Fuse provides a robust authentication system that allows users to register, login, and reset their passwords.

### Login

Users can log in to the application using their email address and password. The login form is accessible at the `/login` route.

```php
// Example login controller method
public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('dashboard');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
}
```

### Registration

New users can register for an account if self-registration is enabled. The registration form is accessible at the `/register` route.

### Password Reset

Users can reset their passwords if they forget them. The password reset flow involves:

1. User requests a password reset link
2. System sends an email with a password reset link
3. User clicks the link and sets a new password

### Email Verification

Fuse supports email verification to ensure that users provide valid email addresses. When enabled, users must verify their email addresses before they can access certain features of the application.

## Authorization

Fuse uses a role-based access control system to manage user permissions. This system is implemented using the [Roles module](modules/roles.md).

### Roles

Roles are collections of permissions that can be assigned to users. Common roles might include:

- Administrator
- Manager
- User

### Permissions

Permissions define what actions a user can perform. Permissions are grouped by module and can be assigned to roles.

### Checking Permissions

To check if a user has a permission:

```php
if (auth()->user()->can('view_users')) {
    // User has permission to view users
}
```

### Middleware

Fuse includes middleware for protecting routes based on permissions:

```php
Route::middleware(['permission:view_users'])->group(function () {
    Route::get('/users', [UserController::class, 'index']);
});
```

## Two-Factor Authentication

Fuse includes support for two-factor authentication (2FA) to enhance security. When enabled, users are required to provide a second form of authentication (typically a code from an authenticator app) after entering their password.

### Enabling 2FA

Users can enable 2FA from their profile settings. The process typically involves:

1. Scanning a QR code with an authenticator app
2. Entering a verification code to confirm setup
3. Saving recovery codes for backup access

### Using 2FA

When 2FA is enabled, users will be prompted for a verification code after entering their password during login.

### Recovery Codes

Recovery codes provide a backup method for accessing an account if the user loses access to their authenticator app. Users should store these codes in a secure location.

## Office Login Only

Fuse includes an "Office Login Only" feature that restricts login to specific IP addresses. This feature can be enabled for individual users or globally.

### Configuring Office Login Only

Administrators can configure the allowed IP addresses in the system settings. When enabled, users can only log in from these IP addresses.

### User-Specific Settings

The "Office Login Only" setting can be enabled or disabled for individual users through the user settings interface.

## User Management

Fuse provides a comprehensive user management system that allows administrators to:

- Create new users
- Edit user details
- Activate or deactivate users
- Assign roles to users
- Invite users to the application

For more details, see the [Users module documentation](modules/users.md).

## Audit Trails

Fuse includes an audit trail system that tracks user actions and changes to models. This helps administrators monitor activity and troubleshoot issues.

For more details, see the [AuditTrails module documentation](modules/audit-trails.md).

## System Settings

Fuse provides a system settings interface that allows administrators to configure various aspects of the application without editing code.

For more details, see the [Settings module documentation](modules/settings.md).

## Next Steps

- [Learn about the modules](modules/index.md)
- [Explore the frontend](frontend.md)
- [Understand the testing framework](testing.md)
