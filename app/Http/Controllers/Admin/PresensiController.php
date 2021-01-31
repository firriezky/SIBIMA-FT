<?php

namespace App\Http\Controllers\Admin;

use App\Agenda;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utility;
use App\Mentee;
use App\Mentor;
use App\Presensi;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;

class PresensiController extends Controller
{
    public function viewGeneral(){
        $general_agenda = Agenda::where('tipe', 2)->paginate(10);

        return view('admin.presensi.general', [
            "general_agenda" => $general_agenda
        ]);
    }

    public function viewTalaqi(){
        $talaqi_agenda = Agenda::where('tipe', 3)->paginate(10);
        return view('admin.presensi.talaqi',[
            'talaqi_agenda' => $talaqi_agenda
        ]);
    }

    // Presensi General Method
    public function inputGeneral($id_agenda){

        // Check if agenda not found
        $agenda = Agenda::find($id_agenda);
        if($agenda == null || $agenda->tipe != 2){
            flash("Agenda not found or match", "danger");
            return redirect(URL::previous());
        }
        
        // take latest 10 presensi
        $latest_presensi = Presensi::latest('id')
            ->where('agenda_id', $id_agenda)
            ->take(5)
            ->get();
        
        return view('admin.presensi.general_input', [
            "agenda" => $agenda,
            "latest_presensi" => $latest_presensi
        ]);
    }
    
    public function postInputGeneral(Request $request, $id_agenda){

        $nim_hadir = $request->input('nim');

        // Check if nim not found
        try {
            $mentee = Mentee::where('nim', $nim_hadir)->firstOrFail();
        } catch (ModelNotFoundException $qe){
            flash('Mentee tidak ditemukan', 'danger');
            return redirect(URL::previous());
        }

        // Check if user already input presensi in current agenda
        if($mentee->getPresensi($id_agenda) != null) {
            flash('Anda sudah Input Presensi', 'danger');
            return redirect(URL::previous());
        }

        // Save Presensi
        $presensi = new Presensi();
        $presensi->agenda_id = $id_agenda;
        $presensi->waktu_hadir = Carbon::now();
        $presensi->mentee_id = $mentee->id;

        // Cek Telat: (Cek telat dengan memanggil method isTelat())
//        if($agenda->isEnded()){
//            $presensi->telat = true;
//        } else {
//            $presensi->telat = false;
//        }

        $presensi->save();
        flash('Terima Kasih sudah menghadiri Mentoring General', 'success');
        return redirect($request->url());


    }

    public function detailGeneral(Request $request, $id_agenda){

        $query = $request->input('search');

        // Check if agenda not found
        $agenda = Agenda::find($id_agenda);
        if($agenda == null || $agenda->tipe != 2){
            flash('Agenda not Found.', 'danger');
            return redirect('admin/presensi/general/');
        } else {
            $list_data = Mentee::where('fakultas', $agenda->fakultas)
                ->whereRaw('(nim = ? or nama like ? or kelas like ?)',
                    [ $query, '%'.$query.'%', '%'.$query.'%'])
                ->paginate(20);
        }

        return view('admin.presensi.general_detail', [
            'agenda' => $agenda,
            'list_data' => $list_data,
            'query' => $query
        ]);

    }

    public function apiGetMentee(Request $request){
        if (!$request->has('query') || !$request->has('fakultas')){
            return response()->json();
        }

        $query = $request->input('query');
        $fakultas = $request->input('fakultas');
        $mentees = DB::table('mentee')
            ->select('mentee.id', 'mentee.nama', 'mentee.nim', 'mentee.kelas')
            ->whereRaw('fakultas = ? and (nama like ? or nim like ?)', [$fakultas, '%'.$query.'%', '%'.$query.'%'])
            ->take(7)
            ->get();
        return response()->json($mentees);

    }
    
    // Presensi Talaqi Method
    public function inputTalaqi($id_agenda){

        // Check if agenda not found
        $agenda = Agenda::find($id_agenda);
        if($agenda == null || $agenda->tipe != 3){
            flash("Agenda not found or match", "danger");
            return redirect(URL::previous());
        }
        
        // take latest 10 presensi
        $latest_presensi = Presensi::latest('id')
            ->where('agenda_id', $id_agenda)
            ->take(5)
            ->get();


        return view('admin.presensi.talaqi_input', [
            "agenda" => $agenda,
            "latest_presensi" => $latest_presensi
        ]);
    }

    public function postInputTalaqi(Request $request, $id_agenda){
        $nim_hadir = $request->input('nim');

        // Check if nim not found
        try {
            $mentor = Mentor::where('nim', $nim_hadir)->firstOrFail();
        } catch (ModelNotFoundException $qe){
            flash('Mentor tidak ditemukan', 'danger');
            return redirect(URL::previous());
        }

        // Check if user already input presensi in current agenda
        if($mentor->getPresensiTalaqi($id_agenda) != null) {
            flash('Anda sudah Input Presensi', 'danger');
            return redirect(URL::previous());
        }

        // Save Presensi
        $presensi = new Presensi();
        $presensi->agenda_id = $id_agenda;
        $presensi->waktu_hadir = Carbon::now();
        $presensi->mentor_id = $mentor->id;

        // Cek Telat: (Cek telat dengan memanggil method isTelat())
//        if($agenda->isEnded()){
//            $presensi->telat = true;
//        } else {
//            $presensi->telat = false;
//        }

        $presensi->save();
        flash('Terima Kasih sudah menghadiri Talaqi', 'success');
        return redirect($request->url());

    }

    public function detailTalaqi(Request $request, $id_agenda){

        $query = $request->input('search');

        // Check if agenda not found
        $agenda = Agenda::find($id_agenda);
//        return $agenda->fakultas;
        if($agenda == null || $agenda->tipe != 3){
            flash("Agenda not found or match", "danger");
            return redirect('admin/presensi/general/');
        } else {
            $list_data = Mentor::where('fakultas', $agenda->fakultas)
                ->whereRaw('(nim = ? or nama like ?)', [ $query, '%'.$query.'%'])
                ->paginate(20);
        }


        return view('admin.presensi.talaqi_detail', [
            'agenda' => $agenda,
            'list_data' => $list_data,
            "query" => $query
        ]);

    }

    public function apiGetMentor(Request $request){
        if (!$request->has('query') || !$request->has('fakultas')){
            return response()->json();
        }

        $query = $request->input('query');
        $fakultas = $request->input('fakultas');

        $mentees = DB::table('mentor')
            ->select('mentor.id', 'mentor.nama', 'mentor.nim', 'mentor.fakultas')
            ->whereRaw('fakultas = ? and (nama like ? or nim like ?)', [$fakultas, '%'.$query.'%', '%'.$query.'%'])
            ->take(7)
            ->get();
        return response()->json($mentees);

    }

    public function viewExport(Request $request){
        
        if ($request->has('fakultas')){
            $query = $request->input('fakultas');

            // BUILD THE HEADER FIRST
            $header = ['NIM', 'Nama', 'JK', 'Fakultas'];
            $agenda_talaqi = Agenda::where('tipe', 3)
                ->where('fakultas', $query)
                ->get();

            // CANCEL EXPORT AND REDIRECT IF THERE ARE NOT ANY AGENDA TALAQI
            if (count($agenda_talaqi) == 0){
                flash($query . " tidak mempunyai agenda talaqi", 'warning');
                return redirect('admin/presensi/talaqi/export');
            }

            foreach ($agenda_talaqi as $agenda){
                array_push($header, $agenda->judul);
                array_push($header, "Log");
            }

            // BUILD DATA BODY CSV
            $list_mentor = Mentor::where('fakultas', $query)
                ->orderBy('nama')
                ->get();

            $data = [];
            foreach ($list_mentor as $mentor){
                $row_mentor = [];

                // Push Data Diri Mentor
                array_push($row_mentor, $mentor->nim);
                array_push($row_mentor, $mentor->nama);
                array_push($row_mentor, $mentor->getJK());
                array_push($row_mentor, $mentor->fakultas);

                // Kehadiran Talaqi
                $presensi_talaqi = $mentor->getPresensiTalaqiSeries();
                for ($i = 0; $i < count($presensi_talaqi); $i++){
                    if ($presensi_talaqi[$i]["presensi"] == null){
                        array_push($row_mentor, "TIDAK HADIR");
                        array_push($row_mentor, "-"); // for log
                    } else if ($presensi_talaqi[$i]["presensi"]->isTelat()){
                        array_push($row_mentor, "TELAT");
                        array_push($row_mentor, $presensi_talaqi[$i]["presensi"]->created_at);
                    } else {
                        array_push($row_mentor, "HADIR");
                        array_push($row_mentor, $presensi_talaqi[$i]["presensi"]->created_at);
                    }

                }

                // push row data mentor to data body
                array_push($data, $row_mentor);
            }

            //Export to Excel
            Excel::create('presensi_talaqi_' . strtolower($query) . "_" . Carbon::now()->toDateString(),
                function($excel) use ($data, $header){
                    $excel->sheet('Sheetname', function($sheet) use ($data, $header){

                        //overwrite header
                        $sheet->fromArray($data);

                        //overwrite header
                        $sheet->row(1, $header);

                    });
                })->export('xlsx');


        } else {
            $list_fakultas_mentor = DB::table('mentor')
                ->select('fakultas')
                ->distinct()->get();

            return view('admin.presensi.talaqi_export', [
                "list_fakultas" => $list_fakultas_mentor
            ]);

        }
    }

}
