<?php

use Illuminate\Database\Seeder;

class UserSubmenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_submenu')->insert([
            'menu_id' => 1,
            'title' => 'Users Management',
            'url' => '/users',
            'icon' => 'fas fa-fw fa-user-edit',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 1,
            'title' => 'Role Management',
            'url' => '/role',
            'icon' => 'fas fa-fw fa-user-tie',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 2,
            'title' => 'Dashboard',
            'url' => '/dashboard',
            'icon' => 'fas fa-fw fa-tachometer-alt',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 3,
            'title' => 'Forests Management',
            'url' => '/forests',
            'icon' => 'fas fa-fw fa-tree',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 3,
            'title' => 'Forests Maps',
            'url' => '/community_forests',
            'icon' => 'fas fa-fw fa-map-marker-alt',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 4,
            'title' => 'Menu Management',
            'url' => '/menu',
            'icon' => 'fas fa-fw fa-folder',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 4,
            'title' => 'Submenu Management',
            'url' => '/submenu',
            'icon' => 'fas fa-fw fa-folder-open',
            'is_active' => 1
        ]);
    }
}
