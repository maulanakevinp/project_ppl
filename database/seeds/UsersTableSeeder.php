<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id' => 1,
            'name' => 'Administrator',
            'image' => 'admin.png',
            'nrp' => '000011112222',
            'password' => Hash::make('admin123')
        ]);
    }
}
