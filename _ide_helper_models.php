<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 *
 *
 * @property string $id
 * @property string|null $user_id
 * @property string $title
 * @property string|null $link
 * @property string $reference_id
 * @property string $section
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User|null $user
 * @method static \Modules\AuditTrails\database\factories\AuditTrailsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\AuditTrails\Models\AuditTrail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\AuditTrails\Models\AuditTrail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\AuditTrails\Models\AuditTrail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\AuditTrails\Models\AuditTrail query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\AuditTrails\Models\AuditTrail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\AuditTrails\Models\AuditTrail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\AuditTrails\Models\AuditTrail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\AuditTrails\Models\AuditTrail whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\AuditTrails\Models\AuditTrail whereReferenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\AuditTrails\Models\AuditTrail whereSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\AuditTrails\Models\AuditTrail whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\AuditTrails\Models\AuditTrail whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\AuditTrails\Models\AuditTrail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\AuditTrails\Models\AuditTrail whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\AuditTrails\Models\AuditTrail withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\AuditTrails\Models\AuditTrail withoutTrashed()
 */
	class AuditTrail extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property string $id
 * @property string $title
 * @property string $assigned_to_user_id
 * @property string $assigned_from_user_id
 * @property string|null $link
 * @property int|null $viewed
 * @property string|null $viewed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $assignedFrom
 * @property-read \App\Models\User $assignedTo
 * @method static \Modules\Admin\Database\Factories\NotificationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Admin\Models\Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Admin\Models\Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Admin\Models\Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Admin\Models\Notification whereAssignedFromUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Admin\Models\Notification whereAssignedToUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Admin\Models\Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Admin\Models\Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Admin\Models\Notification whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Admin\Models\Notification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Admin\Models\Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Admin\Models\Notification whereViewed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Admin\Models\Notification whereViewedAt($value)
 */
	class Notification extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property string $id
 * @property string $name
 * @property string $label
 * @property string $module
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Roles\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Roles\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Permission permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Permission role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Permission whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Permission whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Permission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Permission withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Permission withoutRole($roles, $guard = null)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property string $id
 * @property string $name
 * @property string $label
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Roles\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Role permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Role whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Roles\Models\Role withoutPermission($permissions)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property string $id
 * @property string $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Settings\Models\Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Settings\Models\Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Settings\Models\Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Settings\Models\Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Settings\Models\Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Settings\Models\Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Settings\Models\Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Settings\Models\Setting whereValue($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property string $email
 * @property string|null $password
 * @property string|null $image
 * @property bool $is_office_login_only
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $last_logged_in_at
 * @property bool $two_fa_active
 * @property string|null $two_fa_secret_key
 * @property string|null $invited_by
 * @property \Illuminate\Support\Carbon|null $invited_at
 * @property \Illuminate\Support\Carbon|null $joined_at
 * @property string|null $invite_token
 * @property \Illuminate\Support\Carbon|null $last_activity
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read User|null $invite
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Roles\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Roles\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Modules\Users\Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User isActive()
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereInviteToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereInvitedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereInvitedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsOfficeLoginOnly($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereJoinedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLoggedInAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFaActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFaSecretKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutRole($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

