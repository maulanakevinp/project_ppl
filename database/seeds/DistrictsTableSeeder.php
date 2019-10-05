<?php

use Illuminate\Database\Seeder;
use Ixudra\Curl\Facades\Curl;

class DistrictsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $curl = Curl::to('http://dev.farizdotid.com/api/daerahindonesia/provinsi/kabupaten/3509/kecamatan')->get();
        $curl_decode = json_decode($curl, true);
        $districts = $curl_decode['kecamatans'];
        foreach ($districts as $district) {
            DB::table('districts')->insert([
                'city_id' => 1,
                'district' => $district['nama']
            ]);
        }

        $curl = Curl::to('http://dev.farizdotid.com/api/daerahindonesia/provinsi/kabupaten/3511/kecamatan')->get();
        $curl_decode = json_decode($curl, true);
        $districts = $curl_decode['kecamatans'];
        foreach ($districts as $district) {
            DB::table('districts')->insert([
                'city_id' => 2,
                'district' => $district['nama']
            ]);
        }
    }
}
