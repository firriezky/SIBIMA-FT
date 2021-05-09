<?php

namespace App\Http\Controllers;

use App\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    public function view()
    {
        $myData = DB::select("SELECT a.kode,b.nim,b.nama,b.fakultas,b.no_telp,b.line_id FROM kelompok a LEFT join mentor b on a.mentor_id=b.id where a.id not in (SELECT kelompok_id from berita_mentoring)");
        $acara = Agenda::where('tipe', '=', '1')->get();
        return view('dsc.main')->with(compact('acara','myData'));
    }
    public function viewByID($id)
    {
        $myData = DB::select("SELECT a.kode,b.nama,b.nim,b.fakultas,b.no_telp,b.line_id FROM kelompok a LEFT join mentor b on a.mentor_id=b.id where a.id not in (SELECT kelompok_id from berita_mentoring where agenda_id = $id) ");
        // $item = DB::select("SELECT * from kelompok");
        // dd($myData);
        $agenda = Agenda::find($id);
        return view('dsc.per_agenda')->with(compact('myData','agenda'));

    }
}
