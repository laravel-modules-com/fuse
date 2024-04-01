<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Roles\Models\Permission;

class AppDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Model::unguard();

        Permission::firstOrCreate(['name' => 'view_dashboard', 'label' => 'View Dashboard', 'module' => 'App']);
        Permission::firstOrCreate(['name' => 'view_notifications', 'label' => 'View Notifications', 'module' => 'App']);
    }
}
