<?php

namespace App\Http\Controllers\Admin;

use App\Agenda;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utility;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class AgendaController extends Controller
{
    //
    public function getList(){
        $agendas = Agenda::paginate(10);
        $list_fakultas_mentor = DB::table('mentor')
            ->select('fakultas')
            ->distinct()->get();

        $list_fakultas_mentee = DB::table('mentee')
            ->select('fakultas')
            ->distinct()->get();

        return view('admin.agenda', [
            'agendas' => $agendas,
            'list_fakultas_mentor' => $list_fakultas_mentor,
            'list_fakultas_mentee' => $list_fakultas_mentee

        ]);
    }

    public function addAgenda(Request $request){
    	$judul = $request->input('judul');
    	$tipe = $request->input('tipe');
        try {
            $tanggal_akhir = Carbon::createFromFormat('d/m/Y H:i', $request->input('tanggal_akhir'));
        } catch (InvalidArgumentException $ex) {
            return Utility::response_js('Invalid format date');
        }

    	$new_agenda =  new Agenda();
    	$new_agenda->judul = $judul;
    	$new_agenda->tipe = $tipe;
    	$new_agenda->tanggal_akhir = $tanggal_akhir;

        if ($tipe == 1){
            // Mentoring Biasa, langsung save
            $new_agenda->save();
            flash('Agenda berhasil dibuat.', 'success');
            
        } else if ($tipe == 2 or $tipe == 3) {
            // Mentoring General
            $new_agenda->materi = $request->input('materi');
            $new_agenda->tempat = $request->input('tempat');

            // General / Talaqi Tambah Fakultas
            if ($tipe == 2)
                $new_agenda->fakultas = $request->input('fakultas-general');
            else
                $new_agenda->fakultas = $request->input('fakultas-talaqi');

            $new_agenda->save();
            flash('Agenda berhasil dibuat.', 'success');


        } else if ($tipe == 4) {
            // Tugas Besar / Shining Team Handler
            $tubes = Agenda::where('tipe', 4)->first();

            if ($tubes == null){
                $new_agenda->save();
                flash('Agenda Tugas Akhir berhasil dibuat.', 'success');
            } else {
                flash('Agenda Tugas Akhir sudah di Input.', 'danger');
            }
        }
        
    	return redirect('admin/agenda');

    }

    public function delete(Request $request, $id){
        if ($request->input("password") == "bahayabanget"){
            Agenda::destroy($id);
            flash('Agenda berhasil di delete.', 'success');
        } else {
            flash('Password Salah!!.', 'danger');

        }
        return redirect('admin/agenda');
    }
    
    public function edit(Request $request){
        $agenda_id = $request->input('agenda_id');
        try {
            $tanggal_akhir = Carbon::createFromFormat('d/m/Y H:i', $request->input('tanggal_akhir_baru'));
        } catch (InvalidArgumentException $ex) {
            return Utility::response_js('Invalid format date');
        }

        $agenda = Agenda::find($agenda_id);
        $agenda->tanggal_akhir = $tanggal_akhir;
        $agenda->save();

        flash('Agenda berhasil di update', 'success');
        return redirect('admin/agenda');
    }
}
