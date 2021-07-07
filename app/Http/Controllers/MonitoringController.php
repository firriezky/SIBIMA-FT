<?php

namespace App\Http\Controllers;

use App\Agenda;
use App\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    public function view()
    {
        $myData = DB::select("SELECT a.kode,b.nim,b.nama,b.fakultas,b.no_telp,b.line_id FROM kelompok a LEFT join mentor b on a.mentor_id=b.id where a.id not in (SELECT kelompok_id from berita_mentoring) ");
        $acara = Agenda::where('tipe', '=', '1')->get();
        return view('dsc.main')->with(compact('acara','myData'));
    }
    public function viewByID($id)
    {
        $myData = DB::select("SELECT a.kode,b.nama,b.nim,b.fakultas,b.no_telp,b.line_id FROM kelompok a LEFT join mentor b on a.mentor_id=b.id where a.id not in (SELECT kelompok_id from berita_mentoring where agenda_id = $id) ");
        $agenda = Agenda::find($id);
        return view('dsc.per_agenda')->with(compact('myData','agenda'));

    }

    public function viewReport()
    {
        $myData = DB::select("
        select `berita_mentoring`.*, `kelompok`.`kode` as `kode`, `mentor`.`nama` as `mentor_nama`, `mentor`.`nim` as `mentor_nim`, `agenda`.`judul` as `judul_agenda` from `berita_mentoring` left join `kelompok` on `berita_mentoring`.`kelompok_id` = `kelompok`.`id` left join `mentor` on `kelompok`.`mentor_id` = `mentor`.`id` left join `agenda` on `berita_mentoring`.`agenda_id` = `agenda`.`id` order by nama");
        
        return view('dsc.report.main')->with(compact('myData'));
    }


    public function viewPenggajian()
    {
        $mentors = Mentor::all();
        dd($mentors);
        $myData = DB::select("
        select `berita_mentoring`.*, `kelompok`.`kode` as `kode`, `mentor`.`nama` as `mentor_nama`, `mentor`.`nim` as `mentor_nim`, `agenda`.`judul` as `judul_agenda` from `berita_mentoring` left join `kelompok` on `berita_mentoring`.`kelompok_id` = `kelompok`.`id` left join `mentor` on `kelompok`.`mentor_id` = `mentor`.`id` left join `agenda` on `berita_mentoring`.`agenda_id` = `agenda`.`id` order by nama");
        
        return view('dsc.gaji.main')->with(compact('myData','mentors'));
    }

    // SELECT a.kode , b.nama as `pembimbing kelompok`, b.no_telp FROM kelompok a left join mentor b on a.mentor_id = b.id where a.id not in (SELECT kelompok_id from tugas_besar)
}
