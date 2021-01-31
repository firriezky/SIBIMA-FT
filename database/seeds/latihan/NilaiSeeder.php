<?php

use App\NilaiMentee;
use Illuminate\Database\Seeder;

class NilaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('nilai_mentee')->delete();

        $mentee = App\Mentee::where('nim', '1301160123')->first();
        $berita_mentoring = \App\BeritaMentoring::find(1);

        NilaiMentee::create([
            "berita_mentoring_id" => $berita_mentoring->id,
            "mentee_id" => $mentee->id,
            "nilai_kultum" => 80,
            "nilai_kehadiran" => 90,
        ]);
    }
}
