<?php

namespace App\Http\Controllers\Mentee;

use App\Agenda;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utility;
use App\Mentee;
use App\TugasBesar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TugasBesarController extends Controller
{
    public function input(){
        $kelompok = Auth::guard('mentee')->user()->getKelompok;

        $agenda_tubes = Agenda::where('tipe', 4)->first();

        $list_fakultas_mentee = DB::table('mentee')
            ->select('fakultas')
            ->distinct()->get();

        $latest_tugas_besar = TugasBesar::latest()
            ->take(10)
            ->get();

        return view('mentee.tugas_besar', [
            "kelompok" => $kelompok,
            "latest_tugas_besar" => $latest_tugas_besar,
            'agenda_tubes' => $agenda_tubes,
            "list_fakultas_mentee" => $list_fakultas_mentee
        ]);
    }

    public function submit(Request $request){

        $agenda_tubes = Agenda::where('tipe', 4)->first();
        $fakultas = Auth::guard('mentee')->user()->fakultas;

        //Back-end check tugas besar sudah dibuka?
        if ($agenda_tubes == null){
            return redirect('mentee/tugas-besar');
        }

        //Back-end check tugas besar sudah berakhir?
        if ($agenda_tubes->isEnded()){
            return redirect('mentee/tugas-besar');
        }

        // Back-end check already submit tugas besar() ??
        if(Auth::guard('mentee')->user()->getKelompok->isAlreadySubmitTugasBesar()){
            return Utility::response_js("Kelompok anda sudah submit tugas besar");
        } else {
            $tugas_besar = new TugasBesar();
            $tugas_besar->kelompok_id = Auth::guard('mentee')->user()->getKelompok->id;
            $tugas_besar->judul = $request->input('judul');
            $tugas_besar->video_link = $request->input('video_link');
            $tugas_besar->deskripsi = $request->input('deskripsi');
            $tugas_besar->fakultas = $fakultas;
            $tugas_besar->save();

            return redirect('mentee/tugas-besar');

        }

    }

}
