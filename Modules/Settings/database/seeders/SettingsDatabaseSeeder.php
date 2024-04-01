<?php

namespace Modules\Settings\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Roles\Models\Permission;

class SettingsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::firstOrCreate(['name' => 'view_audit_trails', 'label' => 'View Audit Trails', 'module' => 'Settings']);
        Permission::firstOrCreate(['name' => 'view_system_settings', 'label' => 'View System Settings', 'module' => 'Settings']);
    }
}
