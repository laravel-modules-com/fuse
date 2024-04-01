<?php

namespace Modules\Roles\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Roles\Models\Permission;
use Modules\Roles\Models\Role;

class RolesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin', 'label' => 'Admin']);
        Role::firstOrCreate(['name' => 'user', 'label' => 'User']);
        Role::firstOrCreate(['name' => 'customer', 'label' => 'Customer']);

        Permission::firstOrCreate(['name' => 'view_roles', 'label' => 'View Roles', 'module' => 'Roles']);
        Permission::firstOrCreate(['name' => 'add_roles', 'label' => 'Add Roles', 'module' => 'Roles']);
        Permission::firstOrCreate(['name' => 'edit_roles', 'label' => 'Edit Roles', 'module' => 'Roles']);
        Permission::firstOrCreate(['name' => 'delete_roles', 'label' => 'Delete Roles', 'module' => 'Roles']);
    }
}
