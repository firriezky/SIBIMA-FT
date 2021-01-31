<?php

use Illuminate\Database\Seeder;

class MenteeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('mentee')->delete();

        \App\Mentee::create([
            "nim"=>"1301160123",
            "name" => "Maman Abdurrahman", 
            "password" => "qwerty123",
            "kelompok_id" => 1]);
            
        \App\Mentee::create([
            "nim"=>"1301161123",
            "name" => "Adiwijaya",
            "password" => "qwerty123",
            "kelompok_id" => 1]);
            
        \App\Mentee::create([
            "nim"=>"1301162133",
            "name" => "Florita Sari", 
            "password" => "qwerty123",
            "kelompok_id" => 1]);

    }
}
