<?php

namespace Modules\Contacts\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Roles\Models\Permission;

class ContactsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::firstOrCreate(['name' => 'view_contacts', 'label' => 'View Contacts', 'module' => 'Contacts']);
        Permission::firstOrCreate(['name' => 'add_contacts', 'label' => 'Add Contacts', 'module' => 'Contacts']);
        Permission::firstOrCreate(['name' => 'edit_contacts', 'label' => 'Edit Contacts', 'module' => 'Contacts']);
        Permission::firstOrCreate(['name' => 'delete_contacts', 'label' => 'Delete Contacts', 'module' => 'Contacts']);
    }
}
