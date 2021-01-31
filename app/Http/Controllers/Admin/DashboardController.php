<?php

namespace App\Http\Controllers\Admin;

use App\Agenda;
use App\Http\Controllers\Controller;
use App\Kelompok;
use App\Mentee;
use App\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {
        return redirect('admin/dashboard');
    }

    public function main(){
        $mentor_count = DB::table('mentor')->count(DB::raw('id'));
        $mentee_count = DB::table('mentee')->count(DB::raw('id'));
        $kelompok_count = DB::table('kelompok')->count(DB::raw('id'));

        $fakultas_mentee = DB::table('mentee')
            ->select(DB::raw('DISTINCT fakultas'), DB::raw('COUNT(fakultas) as count'))
            ->groupBy('fakultas')
            ->orderBy('count', 'desc')
            ->get();

        $fakultas_mentor = DB::table('mentor')
            ->select('fakultas', DB::raw('COUNT(fakultas) as count'))
            ->groupBy('fakultas')
            ->orderBy('count', 'desc')
            ->get();

        // Chart Berita Mentoring
        $label_agenda = DB::table('agenda')
            ->where('tipe', 1)
            ->pluck('judul');

        $data_total_berita_mentoring = DB::table('berita_mentoring as bm')
            ->select(DB::raw('count(agenda_id) as total'))
//            ->leftJoin('agenda', 'bm.agenda_id', 'agenda.id')
            ->groupBy('bm.agenda_id')
            ->pluck('total');

        // Chart Talaqi Madah
        $label_agenda_talaqi = DB::table('agenda')
            ->where('tipe', 3)
            ->pluck('judul');

        $data_total_talaqi = DB::table('presensi')
            ->select(DB::raw('count(agenda_id) as total'))
            ->leftJoin('agenda', 'presensi.agenda_id', 'agenda.id')
            ->where('agenda.tipe', 3)
            ->groupBy('presensi.agenda_id')
            ->pluck('total');

        // Chart Agenda General
        $label_agenda_general_temp = DB::table('agenda')
            ->where('tipe', 2)
            ->get();
        $label_agenda_general = [];
        foreach ($label_agenda_general_temp as $label){
            array_push($label_agenda_general, $label->judul . " - " . $label->fakultas);
        }

        $data_total_general = DB::table('presensi')
            ->select(DB::raw('count(agenda_id) as total'))
            ->leftJoin('agenda', 'presensi.agenda_id', 'agenda.id')
            ->where('agenda.tipe', 2)
            ->groupBy('presensi.agenda_id')
            ->pluck('total');



        return view('admin.dashboard', [
            "mentor_count" => $mentor_count,
            "mentee_count" => $mentee_count,
            "kelompok_count" => $kelompok_count,
            "fakultas_mentee" => $fakultas_mentee,
            "fakultas_mentor" => $fakultas_mentor,

            // for Chart
            "label_agenda" => $label_agenda,
            "data_total_berita_mentoring" => $data_total_berita_mentoring,
            "label_agenda_talaqi" => $label_agenda_talaqi,
            "data_total_talaqi" => $data_total_talaqi,
            "label_agenda_general" => json_encode($label_agenda_general),
            "data_total_general" => $data_total_general
        ]);
    }
    
    public function about(){
        return view('admin.about_bima');
    }

}
