<?php

namespace Tests;

use AllowDynamicProperties;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Gate;
use Modules\Roles\Models\Role;

#[AllowDynamicProperties]
abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function authenticate(string $role = 'admin', string $permissionName = ''): self
    {
        $user = $this->prepareUser($role);

        if ($permissionName) {
            Gate::define($permissionName, static function () {
                return true;
            });
        }

        return $this->actingAs($user);
    }

    protected function prepareUser($role): User
    {
        $user = User::factory()->create();

        $this->prepareRole($role);

        $user->assignRole($role);
        $user->save();

        return $user;
    }

    protected function prepareRole($role): Role
    {
        return Role::firstOrCreate([
            'name' => $role,
            'label' => ucwords($role),
        ]);
    }
}
