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
            'title' => 'Role Management',
            'url' => 'role.index',
            'icon' => 'fas fa-fw fa-user-tie',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 1,
            'title' => 'Users Management',
            'url' => 'users.index',
            'icon' => 'fas fa-fw fa-user-edit',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 2,
            'title' => 'Dashboard',
            'url' => 'home',
            'icon' => 'fas fa-fw fa-tachometer-alt',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 3,
            'title' => 'Forests Management',
            'url' => 'forests.index',
            'icon' => 'fas fa-fw fa-tree',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 4,
            'title' => 'My Profile',
            'url' => 'my-profile',
            'icon' => 'fas fa-fw fa-user',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 4,
            'title' => 'Edit Profil',
            'url' => 'edit-profile',
            'icon' => 'fas fa-fw fa-user-edit',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 4,
            'title' => 'Change Password',
            'url' => 'change-password',
            'icon' => 'fas fa-fw fa-key',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 5,
            'title' => 'Menu Management',
            'url' => 'menu.index',
            'icon' => 'fas fa-fw fa-folder',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 5,
            'title' => 'Submenu Management',
            'url' => 'submenu.index',
            'icon' => 'fas fa-fw fa-folder-open',
            'is_active' => 1
        ]);
    }
}
