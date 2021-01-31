<?php

use Illuminate\Database\Seeder;

class MateriSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materi = new \App\Materi();
        $materi->nama = "Birul Walidain";
        $materi->file_url = "storage/id/not-found.pdf";
        $materi->tipe = 1;
        $materi->save();

        $materi = new \App\Materi();
        $materi->nama = "Untuk Mentoring III";
        $materi->file_url = "storage/id/not-found.pdf";
        $materi->tipe = 1;
        $materi->save();

        $materi = new \App\Materi();
        $materi->nama = "Handbook Mentor";
        $materi->file_url = "storage/id/not-found.pdf";
        $materi->tipe = 1;
        $materi->save();

        $materi = new \App\Materi();
        $materi->nama = "Handbook Mentee";
        $materi->file_url = "storage/id/not-found.pdf";
        $materi->tipe = 2;
        $materi->save();

        $materi = new \App\Materi();
        $materi->nama = "Bacaan untuk Mentee";
        $materi->file_url = "storage/id/not-found.pdf";
        $materi->tipe = 2;
        $materi->save();


    }
}
