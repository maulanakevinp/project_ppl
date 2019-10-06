<?php

use Illuminate\Database\Seeder;

class UserMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_menu')->insert([
            'menu' => 'Users',
        ]);

        DB::table('user_menu')->insert([
            'menu' => 'Head of Departement',
        ]);

        DB::table('user_menu')->insert([
            'menu' => 'Forests',
        ]);

        DB::table('user_menu')->insert([
            'menu' => 'Menu',
        ]);
    }
}
