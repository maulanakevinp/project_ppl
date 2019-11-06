<?php

use Illuminate\Database\Seeder;

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
            'role_id'           => 1,
            'nip'               => '199905082017051001',
            'name'              => 'Maulana Kevin Pradana',
            'image'             => 'kevin.jpg',
            'password'          => Hash::make('123123'),
            'reset_password'    => Hash::make('rahasia'),
            'created_at'        => '2019-10-01 00:00:00',
            'updated_at'        => '2019-10-01 00:00:00'
        ]);

        DB::table('users')->insert([
            'role_id'           => 2,
            'nip'               => '199707252015071002',
            'name'              => 'Ermanu Azizul Hakim',
            'image'             => 'manu.jfif',
            'password'          => Hash::make('123123'),
            'reset_password'    => Hash::make('rahasia'),
            'created_at'        => '2019-10-01 00:00:00',
            'updated_at'        => '2019-10-01 00:00:00'
        ]);

        DB::table('users')->insert([
            'role_id'           => 3,
            'nip'               => '199907192017072003',
            'name'              => 'Nilam Wahidah',
            'image'             => 'nilam.jpg',
            'password'          => Hash::make('123123'),
            'reset_password'    => Hash::make('rahasia'),
            'latitude1'         => '-8.199257231587',
            'longitude1'        => '113.65219116210',
            'latitude2'         => '-8.144883388744',
            'longitude2'        => '113.74351501464',
            'created_at'        => '2019-10-01 00:00:00',
            'updated_at'        => '2019-10-01 00:00:00'
        ]);

        DB::table('users')->insert([
            'role_id'           => 3,
            'nip'               => '199807202017072004',
            'name'              => 'Rezza Ulfa Alfanani',
            'image'             => 'rezza.jpg',
            'password'          => Hash::make('123123'),
            'reset_password'    => Hash::make('rahasia'),
            'latitude1'         => '-8.201975728982',
            'longitude1'        => '113.38577270507',
            'latitude2'         => '-8.049711419725',
            'longitude2'        => '113.58215332031',
            'created_at'        => '2019-10-01 00:00:00',
            'updated_at'        => '2019-10-01 00:00:00'
        ]);

        DB::table('users')->insert([
            'role_id'           => 3,
            'nip'               => '199807202017072005',
            'name'              => 'Ika Surya Lestari',
            'image'             => 'ika.jpg',
            'password'          => Hash::make('123123'),
            'reset_password'    => Hash::make('rahasia'),
            'latitude1'         => '-8.430262547918',
            'longitude1'        => '113.53546142578',
            'latitude2'         => '-8.244110057549',
            'longitude2'        => '113.69476318359',
            'created_at'        => '2019-10-01 00:00:00',
            'updated_at'        => '2019-10-01 00:00:00'
        ]);
    }
}
