<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class CSVMentorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
//        $this->seedMentor('misc/sample_data/mentor/MENTOR_FIF_IKHWAN.csv');
        $this->seedMentor('misc/data_16_17_ganjil/mentor/All Mentor Tanpa Jurusan.csv');
    }

    public function seedMentor($dir){

        Excel::load($dir, function($reader) {

            $results = $reader->toArray();

            $arrlength = count($results);

            $dummy_password =  Hash::make(\App\Http\Controllers\Utility::$DEFAULT_MENTOR_PASSWORD);
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

            DB::table('mentor')->insert($results);

        });

    }
}
