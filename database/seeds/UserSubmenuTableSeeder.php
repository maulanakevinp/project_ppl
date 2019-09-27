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
            'title' => 'Dashboard',
            'url' => 'home',
            'icon' => 'fas fa-fw fa-tachometer-alt',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 1,
            'title' => 'Role',
            'url' => 'role.index',
            'icon' => 'fas fa-fw fa-user-tie',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 1,
            'title' => 'User Management',
            'url' => 'users.index',
            'icon' => 'fas fa-fw fa-user-edit',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 2,
            'title' => 'My Profile',
            'url' => 'my-profile',
            'icon' => 'fas fa-fw fa-user',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 2,
            'title' => 'Edit Profil',
            'url' => 'edit-profile',
            'icon' => 'fas fa-fw fa-user-edit',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 2,
            'title' => 'Change Password',
            'url' => 'change-password',
            'icon' => 'fas fa-fw fa-key',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 3,
            'title' => 'Menu Management',
            'url' => 'menu.index',
            'icon' => 'fas fa-fw fa-folder',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 3,
            'title' => 'Submenu Management',
            'url' => 'submenu.index',
            'icon' => 'fas fa-fw fa-folder-open',
            'is_active' => 1
        ]);
    }
}
