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
            'nrp' => '172410101001',
            'password' => Hash::make('123123')
        ]);

        DB::table('users')->insert([
            'role_id' => 2,
            'name' => 'Kepala Dinas',
            'image' => '1569540948_kevin(1).jpg',
            'nrp' => '172410101002',
            'password' => Hash::make('123123')
        ]);

        DB::table('users')->insert([
            'role_id' => 3,
            'name' => 'Pegawai or Staff',
            'image' => '1569512619_admin.png',
            'nrp' => '172410101003',
            'password' => Hash::make('123123')
        ]);
    }
}
