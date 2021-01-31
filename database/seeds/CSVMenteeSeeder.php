<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class CSVMenteeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
//        $this->seedMentee('misc/data_16_17_ganjil/mentee/Ekonomi dan Bisnis.csv');
//        $this->seedMentee('misc/data_16_17_ganjil/mentee/Elektro.csv');
//        $this->seedMentee('misc/data_16_17_ganjil/mentee/Industri Kreatif.csv');
        $this->seedMentee('misc/data_16_17_ganjil/mentee/Informatika.csv');
//        $this->seedMentee('misc/data_16_17_ganjil/mentee/Komunikasi Bisnis.csv');
//        $this->seedMentee('misc/data_16_17_ganjil/mentee/Terapan.csv');
    }

    public function seedMentee($dir){

        Excel::load($dir, function($reader) {

            $results = $reader->toArray();

            $arrlength = count($results);

            $dummy_password =  Hash::make(\App\Http\Controllers\Utility::$DEFAULT_MENTEE_PASSWORD);
            $date_now = Carbon::now();

            // Rebuild Array, filling password, and date
            for($x = 0; $x < $arrlength; $x++) {
                $results[$x]['nama'] = strtoupper($results[$x]['nama']);
                $results[$x]['password'] = $dummy_password;
                $results[$x]['created_at'] = $date_now;
                $results[$x]['updated_at'] = $date_now;

                // Reformat Jenis Kelamin, akan raise exception jika tidak masuk kondisi ini
                if (strtolower($results[$x]['jk']) == "pria" or
                    strtolower($results[$x]['jk']) == "laki-laki") {
                    $results[$x]['jk'] = 1;
                }
                else if (strtolower($results[$x]['jk']) == "wanita" or
                    strtolower($results[$x]['jk']) == "perempuan") {
                    $results[$x]['jk'] = 2;
                }

            }

            DB::table('mentee')->insert($results);

        });

    }
}
