<?php

use Illuminate\Database\Seeder;

class QuestionerSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $questioner = new \App\Questioner();
        $questioner->judul = "Questioner buat Mentor";
        $questioner->link = 'http://www.mangastream.com';
        $questioner->koresponden = 1; //mentor
        $questioner->save();

        //
        $questioner = new \App\Questioner();
        $questioner->judul = "Questioner buat Mentee";
        $questioner->link = 'http://www.mangastream.com';
        $questioner->koresponden = 2; //mentor
        $questioner->save();

        //
        $questioner = new \App\Questioner();
        $questioner->judul = "Frekuensi Tilawah";
        $questioner->link = 'http://www.mangastream.com';
        $questioner->koresponden = 1; //mentor
        $questioner->save();

        //
        $questioner = new \App\Questioner();
        $questioner->judul = "Frekuensi Tilawah";
        $questioner->link = 'http://www.mangastream.com';
        $questioner->koresponden = 2; //mentor
        $questioner->save();

    }
}

