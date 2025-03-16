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
 * @property string $name
 * @property string $slug
 * @property string $email
 * @property string|null $password
 * @property string|null $image
 * @property bool $is_office_login_only
 * @property bool $is_active
 * @property \Carbon\CarbonImmutable|null $email_verified_at
 * @property \Carbon\CarbonImmutable|null $last_logged_in_at
 * @property bool $two_fa_active
 * @property string|null $two_fa_secret_key
 * @property string|null $invited_by
 * @property \Carbon\CarbonImmutable|null $invited_at
 * @property \Carbon\CarbonImmutable|null $joined_at
 * @property string|null $invite_token
 * @property \Carbon\CarbonImmutable|null $last_activity
 * @property string|null $remember_token
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User isActive()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereInviteToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereInvitedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereInvitedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsOfficeLoginOnly($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereJoinedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastLoggedInAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFaActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFaSecretKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTrashed()
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

namespace Modules\Admin\Models{
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
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User $assignedFrom
 * @property-read \App\Models\User $assignedTo
 * @method static \Modules\Admin\Database\Factories\NotificationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereAssignedFromUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereAssignedToUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereViewed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereViewedAt($value)
 */
	class Notification extends \Eloquent {}
}

namespace Modules\AuditTrails\Models{
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
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property-read \App\Models\User|null $user
 * @method static \Modules\AuditTrails\Database\Factories\AuditTrailsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditTrail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditTrail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditTrail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditTrail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditTrail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditTrail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditTrail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditTrail whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditTrail whereReferenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditTrail whereSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditTrail whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditTrail whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditTrail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditTrail whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditTrail withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AuditTrail withoutTrashed()
 */
	class AuditTrail extends \Eloquent {}
}

namespace Modules\Blog\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property string|null $image
 * @property string|null $bio
 * @property string|null $facebook
 * @property string|null $instagram
 * @property string|null $linkedin
 * @property string|null $twitter
 * @property string|null $github
 * @property string|null $youtube
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Blog\Models\Post> $posts
 * @property-read int|null $posts_count
 * @method static \Modules\Blog\Database\Factories\AuthorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereGithub($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereInstagram($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereLinkedin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereTwitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereYoutube($value)
 */
	class Author extends \Eloquent {}
}

namespace Modules\Blog\Models{
/**
 * 
 *
 * @property string $id
 * @property string $parent_id
 * @property string $title
 * @property string $slug
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Blog\Models\Post> $posts
 * @property-read int|null $posts_count
 * @method static \Modules\Blog\Database\Factories\CategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category order()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace Modules\Blog\Models{
/**
 * 
 *
 * @property string $category_id
 * @property string $post_id
 * @method static \Modules\Blog\Database\Factories\CategoryPostFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryPost newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryPost newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryPost query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryPost whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryPost wherePostId($value)
 */
	class CategoryPost extends \Eloquent {}
}

namespace Modules\Blog\Models{
/**
 * 
 *
 * @property string $id
 * @property string $title
 * @property string $slug
 * @property string|null $image
 * @property string $author_id
 * @property string|null $description
 * @property string|null $content
 * @property \Carbon\CarbonImmutable $display_at
 * @property string|null $shortlink
 * @property string|null $download
 * @property string|null $demo
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Modules\Blog\Models\Author|null $author
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Blog\Models\Category> $categories
 * @property-read int|null $categories_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post date()
 * @method static \Modules\Blog\Database\Factories\PostFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post order()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereDemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereDisplayAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereDownload($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereShortlink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUpdatedAt($value)
 */
	class Post extends \Eloquent {}
}

namespace Modules\Roles\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string $label
 * @property string $module
 * @property string $guard_name
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Roles\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission withoutRole($roles, $guard = null)
 */
	class Permission extends \Eloquent {}
}

namespace Modules\Roles\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string $label
 * @property string $guard_name
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Roles\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role withoutPermission($permissions)
 */
	class Role extends \Eloquent {}
}

namespace Modules\Settings\Models{
/**
 * 
 *
 * @property string $id
 * @property string $key
 * @property string|null $value
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereValue($value)
 */
	class Setting extends \Eloquent {}
}

