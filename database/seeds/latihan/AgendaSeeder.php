<?php

use Illuminate\Database\Seeder;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('agenda')->delete();

        $agenda = new \App\Agenda();
        $agenda->nama = "Mentoring 1";
        $agenda->tanggal_akhir = Carbon\Carbon::yesterday();
        $agenda->save();

        $agenda = new \App\Agenda();
        $agenda->nama = "Mentoring 2";
        $agenda->tanggal_akhir = Carbon\Carbon::tomorrow();
        $agenda->save();

        $agenda = new \App\Agenda();
        $agenda->nama = "Mentoring General 2016";
        $agenda->tanggal_akhir = Carbon\Carbon::tomorrow();
        $agenda->save();


    }
}
