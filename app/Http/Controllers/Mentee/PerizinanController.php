<?php
/**
 * Created by PhpStorm.
 * User: Bismillah
 * Date: 30/12/2016
 * Time: 18.45
 */

namespace App\Http\Controllers\Mentee;

use App\Agenda;
use App\IzinGeneral;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class PerizinanController extends Controller
{
    public function perizinan(){

        $mentee = Auth::guard('mentee')->user();

        // Get Data Izin
        $izins = $mentee->getIzinGeneral;

        // Get General yang belum berakhir
        $agendas_general = Agenda::where('tipe', 2)
            ->where('fakultas', $mentee->fakultas)
            ->whereDate('tanggal_akhir', '>', Carbon::now())
            ->get();

        // Cek agenda general yang mentee belum izin.
        $agendas_not_propose = [];
        foreach ($agendas_general as $agenda){
            if (!$agenda->isMenteeProposeIzinGeneral($mentee->id)){
                array_push($agendas_not_propose, $agenda);
            }
        }
        
        return view('mentee.perizinan', [
            "agendas_general" => $agendas_not_propose,
            "izins" => $izins,
            "mentee_id" => Auth::guard('mentee')->user()->id
        ]);
    }

    public function submit(Request $request){

        $file = $request->file('file_surat');
        $extension = $file->getClientOriginalExtension();

        if($extension == "jpg" || $extension == "pdf" || $extension == "png"){
            $izin = new IzinGeneral();
            $izin->mentee_id = Auth::guard('mentee')->user()->id;
            $izin->agenda_id = $request->input('agenda');
            $izin->kategori = $request->input('kategori');
            $izin->detail = $request->input('detail');
            $izin->surat_url = "";
            $izin->save();

            try {

                $path = $file->storeAs('storage/izin_attach/' . $izin->id, $file->getClientOriginalName(), 'public');

                $izin->surat_url = $path;
                $izin->save();
                flash("Perizinan Mentoring General telah diajukan");
            } catch (\Exception $ex) {
                flash("Failed, file limit exceeded", 'danger');
                $izin->delete();
            }
            
        } else{
            flash("Format file surat izin yang diterima hanyalah .jpg / .png / .pdf", "danger");
        }


        return redirect('mentee/perizinan');

    }
    
}