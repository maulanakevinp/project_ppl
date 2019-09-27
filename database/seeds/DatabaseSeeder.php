<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserRoleTableSeeder::class,
            UsersTableSeeder::class,
            UserMenuTableSeeder::class,
            UserAccessMenuTableSeeder::class,
            UserSubmenuTableSeeder::class,
        ]);
    }
}
