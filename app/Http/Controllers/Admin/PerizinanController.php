<?php
/**
 * Created by PhpStorm.
 * User: Bismillah
 * Date: 30/12/2016
 * Time: 18.41
 */

namespace App\Http\Controllers\Admin;


use App\Agenda;
use App\Http\Controllers\Controller;
use App\IzinGeneral;
use App\Presensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class PerizinanController extends Controller
{

    public function perizinan(Request $request){

        $current_agenda = $request->input('agenda');
        $query = $request->input('search');
        $agenda_general = Agenda::where('tipe', 2)->get();

        if ($request->has('agenda')){
            $list_izin = IzinGeneral::latest()
                ->select('izin_general.*', 'mentee.nama as mentee_nama', 'mentee.nim as mentee_nim', 
                    'mentee.fakultas as mentee_fakultas')
                ->leftJoin('mentee', 'izin_general.mentee_id', 'mentee.id')
                ->whereRaw('izin_general.agenda_id = ? and (mentee.nama like ? or mentee.nim = ? or mentee.fakultas like ?)',
                    [ $current_agenda,'%'.$query.'%', '%'.$query.'%', '%'.$query.'%' ]
                )
                ->paginate(10);

        } else {
            $list_izin = IzinGeneral::latest()
                ->select('izin_general.*', 'mentee.nama as mentee_nama', 'mentee.nim as mentee_nim',
                    'mentee.fakultas as mentee_fakultas')
                ->leftJoin('mentee', 'izin_general.mentee_id', 'mentee.id')
                ->whereRaw('mentee.nama like ? or mentee.nim = ? or mentee.fakultas like ?',
                    ['%'.$query.'%', '%'.$query.'%', '%'.$query.'%' ]
                )
                ->paginate(10);
        }

        return view('admin.presensi.perizinan', [
            "list_izin" => $list_izin,
            "agenda_general" => $agenda_general,
            "current_agenda" => $current_agenda,
            "query" => $query
        ]);
    }

    public function reject($id){
        $izin = IzinGeneral::find($id);

        if ($izin == null){
            flash("Perizinan Data not found", "danger");
            return redirect(URL::previous);
        } else {

            $izin->status = 2;
            $izin->save();

        }

        // Delete Presensi, apabila sebelumnya telah acc
        $presensi = Presensi::where('mentee_id', $izin->mentee_id)
            ->where('agenda_id', $izin->agenda_id)
            ->first();
        if ($presensi != null){
            $presensi->delete();
        }

        flash("Izin berhasil di reject", 'success');
        return redirect(URL::previous());
    }

    public function accepted($id){
        $izin = IzinGeneral::find($id);
        if ($izin == null){
            flash("Perizinan Data not found", "danger");
            return redirect(URL::previous);
        } else {

            $izin->status = 1;
            $izin->save();

        }

        $presensi = Presensi::where('mentee_id', $izin->mentee_id)
            ->where('agenda_id', $izin->agenda_id)
            ->first();
        if ($presensi == null){
            $presensi = new Presensi();
            $presensi->agenda_id = $izin->agenda_id;
            $presensi->mentee_id = $izin->mentee_id;
            $presensi->waktu_hadir = Carbon::now();
            $presensi->tugas = true;
            $presensi->save();
        }

        flash("Izin berhasil di Acc", 'success');
        return redirect(URL::previous());

    }

    public function delete($id){
        $izin = IzinGeneral::find($id);
        $presensi = Presensi::where('mentee_id', $izin->mentee_id)
            ->where('agenda_id', $izin->agenda_id)
            ->first();
        if($presensi != null){
            $presensi->delete();
        } 
        $izin->delete();

        flash('Izin general berhasil dihapus', 'success');
        return redirect('admin/presensi/perizinan');
    }

}