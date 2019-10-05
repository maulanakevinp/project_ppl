<?php

use Illuminate\Database\Seeder;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_role')->insert([
            'role' => 'Staff IT'
        ]);

        DB::table('user_role')->insert([
            'role' => 'Kepala Dinas'
        ]);

        DB::table('user_role')->insert([
            'role' => 'Pegawai'
        ]);
    }
}
