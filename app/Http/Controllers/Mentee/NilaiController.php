<?php

namespace App\Http\Controllers\Mentee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    //
    public function main(){

        $mentee = Auth::guard('mentee')->user();

        // TODO : BUG NILAI DUPLIKAT JIKA PINDAH MENTEE
        // JIKA MENTOR INPUT NILAI 2 KALI DI KELOMPOK SEBELUM DAN SESUDAH
        // KEMUNGKINAN TERJADI : KECIL
        
        // Get Nilai Mentoring Mentee
        $nilai_mentoring = $mentee->getNilai;

        // Get Nilai General (Presensi)
        $nilai_general = $mentee->getPresensiGeneral();

        // Get Nilai Tugas Besar
        if ($mentee->getKelompok != null) {
            $nilai_tugas_besar = $mentee->getKelompok->getTugasBesar;
        } else {
            $nilai_tugas_besar = null;
        }

        // Statistik Mentee
        $id_mentee = Auth::guard('mentee')->user()->id;
        $data_nilai = DB::table('nilai_mentee')
            ->where('mentee_id', $id_mentee)
            ->pluck('kehadiran');
        $data_kultum = DB::table('nilai_mentee')
            ->where('mentee_id', $id_mentee)
            ->pluck('kultum');
        $label_nilai = DB::table('nilai_mentee as n')
            ->where('mentee_id', $id_mentee)
            ->leftJoin('berita_mentoring as bm', 'n.berita_mentoring_id', '=', 'bm.id')
            ->leftJoin('agenda', 'bm.agenda_id', '=', 'agenda.id')
            ->pluck('agenda.judul');

        // Statistik for Mentoring General (TODO: Future Update)
//        $data_general = array_map(function($nilai) {return $nilai['nilai'];}, $nilai_general);
//        $label_general = array_map(function($nilai) {return $nilai['agenda'];}, $nilai_general);

//        return response()->json($data_general);

        return view('mentee.nilai', [
            "nilai_mentoring" => $nilai_mentoring,
            "nilai_general" => $nilai_general ,
            "nilai_tugas_besar" => $nilai_tugas_besar,
            // for statistik
            "data_nilai" => $data_nilai,
            "label_nilai" => $label_nilai,
            "data_kultum" => $data_kultum

//            "data_general" => $data_general,
//            "label_general" => $label_general,
        ]);
    }
}
