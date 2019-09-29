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
            'nip' => '172410101001',
            'name' => 'Administrator',
            'image' => 'admin.png',
            'password' => Hash::make('123123'),
            'reset_password' => Hash::make('rahasia')
        ]);

        DB::table('users')->insert([
            'role_id' => 2,
            'nip' => '172410101002',
            'name' => 'Kepala Dinas',
            'image' => '1569540948_kevin(1).jpg',
            'password' => Hash::make('123123'),
            'reset_password' => Hash::make('rahasia')
        ]);

        DB::table('users')->insert([
            'role_id' => 3,
            'nip' => '172410101003',
            'name' => 'Pegawai or Staff',
            'image' => '1569512619_admin.png',
            'password' => Hash::make('123123'),
            'reset_password' => Hash::make('rahasia')
        ]);
    }
}
