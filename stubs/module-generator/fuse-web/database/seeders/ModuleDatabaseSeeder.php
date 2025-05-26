<?php

namespace Modules\{Module}\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Roles\Models\Permission;

class {Module}DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Permission::firstOrCreate(['name' => 'view_{module_}', 'label' => 'View {Module }', 'module' => '{Module}']);
        Permission::firstOrCreate(['name' => 'add_{module_}', 'label' => 'Add {Module }', 'module' => '{Module}']);
        Permission::firstOrCreate(['name' => 'edit_{module_}', 'label' => 'Edit {Module }', 'module' => '{Module}']);
        Permission::firstOrCreate(['name' => 'export_{module_}', 'label' => 'Export {Module }', 'module' => '{Module}']);
        Permission::firstOrCreate(['name' => 'import_{module_}', 'label' => 'Import {Module }', 'module' => '{Module}']);
        Permission::firstOrCreate(['name' => 'delete_{module_}', 'label' => 'Delete {Module }', 'module' => '{Module}']);
    }
}
