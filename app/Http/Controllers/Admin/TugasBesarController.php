<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mentee;
use App\TugasBesar;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasBesarController extends Controller
{
    //
    public function index(Request $request){
        // $list_tugas_besar = TugasBesar::all();
        $search = $request->input('search');
        $list_tugas_besar = TugasBesar::select('tugas_besar.*')
                                ->leftJoin('kelompok as kelompok', 'kelompok_id', 'kelompok.id')
                                ->leftJoin('mentor as mentor', 'mentor_id', 'mentor.id')
                                ->where('tugas_besar.fakultas','like','%'.$search.'%')
                                ->orWhere('nama','like','%'.$search.'%')
                                ->paginate(10);
        $list_fakultas = DB::table('mentee')
                            ->select('fakultas')
                            ->groupBy('fakultas')
                            ->get();
        return view('admin.tugas_besar', [
            "list_tugas_besar" => $list_tugas_besar,
            "list_fakultas" => $list_fakultas,
            "search" => $search
        ]);
    }

    public function submit(Request $request){

        $tugas_besar = TugasBesar::find($request->input('kelompok_id'));
        if($tugas_besar == null){
            return response()->json([
                'status' => 503,
                'message' => 'Tugas Besar data not found'
            ]);
        }

        $tugas_besar->nilai = $request->input('nilai');
        $tugas_besar->save();

        return response()->json([
            'status' => 200,
            'message' => 'Nilai Tugas Besar updated'
        ]);

    }

    public function submitTelat(Request $request){

        $mentee = Mentee::where('nim', $request->input('nim'))->first();

        if ($mentee == null){
            flash('Mentee perwakilan tidak ditemukan', 'warning');
            return redirect('admin/tugas-besar');
        } elseif ($mentee->getKelompok == null){
            flash('Mentee Belum mempunyai kelompok!!', 'danger');
            return redirect('admin/tugas-besar');
        } elseif ($mentee->getKelompok->isAlreadySubmitTugasBesar()){
            flash('Kelompok Mentee perwakilan sudah submit tugas besar', 'info');
            return redirect('admin/tugas-besar');
        }

        $tugas_besar = new TugasBesar();
        $tugas_besar->kelompok_id = $mentee->getKelompok->id;
        $tugas_besar->judul = $request->input('judul');
        $tugas_besar->video_link = $request->input('video_link');
        $tugas_besar->deskripsi = $request->input('deskripsi');
        $tugas_besar->fakultas = $request->input('fakultas');
        $tugas_besar->nilai = $request->input('nilai');

        $tugas_besar->save();

        flash('Input Tugas Besar (Telat) Berhasil', 'info');
        return redirect('admin/tugas-besar');

    }

    public function delete($id){
        TugasBesar::destroy($id);
        flash('Tugas Besar berhasil di delete', 'success');
        return redirect('admin/tugas-besar');
    }
}
