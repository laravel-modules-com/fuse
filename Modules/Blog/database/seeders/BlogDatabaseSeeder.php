<?php

namespace Modules\Blog\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Roles\Models\Permission;

class BlogDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::firstOrCreate(['name' => 'view_blog_posts', 'label' => 'View Posts', 'module' => 'Blog']);
        Permission::firstOrCreate(['name' => 'add_blog_posts', 'label' => 'Add Posts', 'module' => 'Blog']);
        Permission::firstOrCreate(['name' => 'edit_blog_posts', 'label' => 'Edit Posts', 'module' => 'Blog']);
        Permission::firstOrCreate(['name' => 'delete_blog_posts', 'label' => 'Delete Posts', 'module' => 'Blog']);

        Permission::firstOrCreate(['name' => 'view_blog_categories', 'label' => 'View Categories', 'module' => 'Blog']);
        Permission::firstOrCreate(['name' => 'add_blog_categories', 'label' => 'Add Categories', 'module' => 'Blog']);
        Permission::firstOrCreate(['name' => 'edit_blog_categories', 'label' => 'Edit Categories', 'module' => 'Blog']);
        Permission::firstOrCreate(['name' => 'delete_blog_categories', 'label' => 'Delete Categories', 'module' => 'Blog']);

        Permission::firstOrCreate(['name' => 'view_blog_authors', 'label' => 'View Authors', 'module' => 'Blog']);
        Permission::firstOrCreate(['name' => 'add_blog_authors', 'label' => 'Add Authors', 'module' => 'Blog']);
        Permission::firstOrCreate(['name' => 'edit_blog_authors', 'label' => 'Edit Authors', 'module' => 'Blog']);
        Permission::firstOrCreate(['name' => 'delete_blog_authors', 'label' => 'Delete Authors', 'module' => 'Blog']);
    }
}
