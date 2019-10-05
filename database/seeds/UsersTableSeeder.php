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
            'nip' => '199905082017051001',
            'name' => 'Maulana Kevin Pradana',
            'image' => '1569540948_kevin(1).jpg',
            'password' => Hash::make('123123'),
            'reset_password' => Hash::make('rahasia')
        ]);

        DB::table('users')->insert([
            'role_id' => 2,
            'nip' => '199707252015071002',
            'name' => 'Ermanu Azizul Hakim',
            'image' => 'manu.jfif',
            'password' => Hash::make('123123'),
            'reset_password' => Hash::make('rahasia')
        ]);

        DB::table('users')->insert([
            'role_id' => 3,
            'nip' => '199907192017072003',
            'name' => 'Nilam Wahidah',
            'image' => 'nilam.jpg',
            'password' => Hash::make('123123'),
            'reset_password' => Hash::make('rahasia')
        ]);

        DB::table('users')->insert([
            'role_id' => 3,
            'nip' => '199807202017072004',
            'name' => 'Rezza Ulfa Alfanani',
            'image' => 'rezza.jpg',
            'password' => Hash::make('123123'),
            'reset_password' => Hash::make('rahasia')
        ]);

        DB::table('users')->insert([
            'role_id' => 3,
            'nip' => '199807202017072005',
            'name' => 'Ika Surya Lestari',
            'image' => 'ika.jpg',
            'password' => Hash::make('123123'),
            'reset_password' => Hash::make('rahasia')
        ]);
    }
}
