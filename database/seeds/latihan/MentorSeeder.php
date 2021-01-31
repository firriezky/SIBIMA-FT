<?php

use Illuminate\Database\Seeder;

class MentorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('mentor')->delete();

        \App\Mentor::create(["nim"=>"1301140171","nama" => "Dede Kiswanto"]);
        \App\Mentor::create(["nim"=>"1301140012","nama" => "Bambang Hariyanto"]);
        \App\Mentor::create(["nim"=>"1301123301","nama" => "Budi Rahardjo"]);
        \App\Mentor::create(["nim"=>"1201140171","nama" => "Munir Tersangka"]);

    }
}
