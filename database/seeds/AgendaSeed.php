<?php

use Illuminate\Database\Seeder;

class AgendaSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $agenda = new \App\Agenda();
        $agenda->tipe = 2;
        $agenda->tanggal_akhir = Carbon\Carbon::now()->yesterday();
        $agenda->judul = "Opening ICB";
        $agenda->fakultas = "INFORMATIKA";
        $agenda->save();

        $agenda = new \App\Agenda();
        $agenda->tipe = 1;
        $agenda->tanggal_akhir = Carbon\Carbon::now()->addDays(1);
        $agenda->judul = "Mentoring 1";
        $agenda->save();

        $agenda = new \App\Agenda();
        $agenda->tipe = 1;
        $agenda->tanggal_akhir = Carbon\Carbon::now()->addWeeks(1);
        $agenda->judul = "Mentoring 2";
        $agenda->save();

        $agenda = new \App\Agenda();
        $agenda->tipe = 1;
        $agenda->tanggal_akhir = Carbon\Carbon::now()->addWeeks(2);
        $agenda->judul = "Mentoring 3";
        $agenda->save();

        $agenda = new \App\Agenda();
        $agenda->tipe = 2;
        $agenda->tanggal_akhir = Carbon\Carbon::now()->addWeeks(3);
        $agenda->judul = "Mentoring General II";
        $agenda->fakultas = "INFORMATIKA";
        $agenda->save();

        $agenda = new \App\Agenda();
        $agenda->tipe = 1;
        $agenda->tanggal_akhir = Carbon\Carbon::now()->addWeeks(4);
        $agenda->judul = "Mentoring 4";
        $agenda->save();

        $agenda = new \App\Agenda();
        $agenda->tipe = 1;
        $agenda->tanggal_akhir = Carbon\Carbon::now()->addWeeks(5);
        $agenda->judul = "Mentoring 5";
        $agenda->save();

        $agenda = new \App\Agenda();
        $agenda->tipe = 1;
        $agenda->tanggal_akhir = Carbon\Carbon::now()->addWeeks(6);
        $agenda->judul = "Mentoring 6";
        $agenda->save();

        $agenda = new \App\Agenda();
        $agenda->tipe = 2;
        $agenda->tanggal_akhir = Carbon\Carbon::now()->addWeeks(7);
        $agenda->judul = "Closing MPAI";
        $agenda->fakultas = "INFORMATIKA";
        $agenda->save();
        
    }
}
