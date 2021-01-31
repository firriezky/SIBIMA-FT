<?php

use Illuminate\Database\Seeder;

class BeritaMentoringSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kelompok = App\Kelompok::where('id', 1)->first();
        
        \App\BeritaMentoring::create([
            "kelompok_id" => $kelompok->id,
            "tempat" => "MSU",
            "materi" => "Mengenal Islam",
        ]);
      
    }
}
