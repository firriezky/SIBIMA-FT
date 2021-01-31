<?php

namespace App\Http\Controllers\Admin;

use App\Kelompok;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Mentee;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Agenda;


class ExportController extends Controller
{
    public function buildHeaderMentee($fakultas){
        $header = ["kelompok", 'nama', 'nim', 'jk', 'kelas'];
        // Add Header Nilai Mentoring
        foreach (Agenda::where('tipe', 1)->pluck('judul') as $agenda){
            array_push($header, $agenda);
            array_push($header, "Kultum " . $agenda);
        }
        // Add Header General Mentoring
        foreach (Agenda::where('tipe', 2)->where('fakultas', $fakultas)->pluck('judul') as $agenda){
            array_push($header, $agenda);
        }

        // Add Header General Tugas Besar
        array_push($header, "Tugas Besar");

        // Add Header Nilai Akhir
        array_push($header, "Nilai Akhir");

        return $header;
    }

    public function buildRowMentee($mentee){
        $row = array();

        // Conter untuk Nilai Akhir
        $nilai_mentoring_counter = 0;
        $nilai_kultum_counter = 0;
        $nilai_general_counter = 0;

        // Add Kelompok Column
        $kelompok = $mentee->getKelompok;
        if ($kelompok == null) {
            array_push($row, "NULL");
        } else {
            array_push($row, $kelompok->kode);
        }

        // Add Data Diri Column (nama, nim, jk, kelas)
        array_push($row, $mentee->nim);
        array_push($row, $mentee->nama);
        array_push($row, $mentee->getJK());
        array_push($row, $mentee->kelas);

        // add nilai mentoring column
        $nilais = $mentee->getNilaiMentoringSeries();
        foreach ($nilais as $nilai) {
            if ($nilai['nilai'] != null) {
                array_push($row, $nilai['nilai']);

                // counter nilai akhir
                $nilai_mentoring_counter += $nilai['nilai'];

                // Library can't write zero int to excel
                // replace it with zero string
                if ($nilai['kultum'] != 0){
                    array_push($row, $nilai['kultum']);

                    // Ambil Nilai Kultum terbesar
                    if ($nilai['kultum'] > $nilai_kultum_counter )
                        $nilai_kultum_counter = $nilai['kultum'];

                } else {
                    array_push($row, "0");
                }
            } else {
                array_push($row, 'NULL');
                array_push($row, 'NULL');
            }
        }

        // Row Ditambah Nilai General
        $nilai_general = $mentee->getPresensiGeneral();
        foreach ($nilai_general as $general) {
            if ($general['nilai'] == 0)
                array_push($row, "0");
            else {
                array_push($row, $general['nilai']);
                $nilai_general_counter += $general['nilai'];
            }
        }

        // Row Ditambah Nilai Tugas/Besar
        $nilai_tubes = 0;
        if ($kelompok == null || !$kelompok->isAlreadySubmitTugasBesar()) {
            array_push($row, "NULL");
        } else {
            $nilai_tubes = $kelompok->getTugasBesar->nilai;
            array_push($row, $nilai_tubes);
        }

        // Hitung Nilai Akhir
        $na_mentoring = ($nilai_mentoring_counter + $nilai_kultum_counter) / (count($nilais) + 1) * 0.55 ;

        if (count($nilai_general) != 0){
            $na_general = $nilai_general_counter / count($nilai_general) * 0.35;
        } else {
            $na_general = 0;
        }

        $na_tubes = $nilai_tubes * 0.1;

        $nilai_akhir = $na_mentoring + $na_general + $na_tubes;

        if ($nilai_akhir != 0)
            array_push($row, round($nilai_akhir,2));
        else
            array_push($row, "0");

        return $row;
        //[ kode_kelompk, nama, nim, nama, jk, kelas, nilai_mentoring & kultum,
        //  nilai_general, nilai_tugas_besar, nilai_akhir ]
    }

    public function menuExport(){
//        $list_prodi = DB::table('mentee')
//            ->select('program_studi')
//            ->distinct()->get();

        $list_fakultas = DB::table('mentee')
            ->select('fakultas')
            ->distinct()->get();

        return view('admin.berita_mentoring.export_menu', [
//            'list_prodi' => $list_prodi,
            'list_fakultas' => $list_fakultas
        ]);
    }

    public function exportData(Request $request){

        // Remove Export by JK due to add fakultas to Agenda General
        
//        if ($request->has('jk')){
//            $query = $request->input('jk');
//            if ($query == "ikhwan"){
//                $list_kelompok = Kelompok::where('type', 1)->get();
//            } else if ($query == "akhwat") {
//                $list_kelompok = Kelompok::where('type', 2)->get();
//            } else {
//                $list_kelompok = null;
//            }
//
//
//            // Array Series that will insert into sheet
//            $data_series = array();
//
//            foreach ($list_kelompok as $kelompok){
//
//                foreach ($kelompok->getMentee as $mentee){
//
//                    $row = $this->buildRowMentee($mentee);
//                    array_push($data_series, $row);
//
//                }
//            }

        if ($request->has('fakultas')){

            $query = $request->input('fakultas');
            $mentees = Mentee::where('fakultas', $query)
                ->orderBy('kelas', 'asc')
                ->get();

            // Array Series that will insert into sheet
            $data_series = array();

            // Make Mentee Rows
            foreach ($mentees as $mentee) {
                $row = $this->buildRowMentee($mentee);
                array_push($data_series, $row);
            }


//        } elseif ($request->has('prodi')){
//            
//            $query = $request->input('prodi');
//            $mentees = Mentee::where('program_studi', $query)
//                ->orderBy('kelas', 'asc')
//                ->get();
//
//            // Array Series that will insert into sheet
//            $data_series = array();
//
//            // Make Mentee Rows
//            foreach ($mentees as $mentee) {
//                $row = $this->buildRowMentee($mentee);
//                array_push($data_series, $row);
//            }

        } else {
            return redirect('admin/berita-mentoring/export');
        }

        $fakultas = $request->input('fakultas');
        // Export Excel
        Excel::create('berita_mentoring_' . strtolower($query) . "_" . Carbon::now()->toDateString(), function($excel) use ($data_series, $fakultas){
            $excel->sheet('Sheetname', function($sheet) use ($data_series, $fakultas){
                
                // Overwrite Header
                $sheet->fromArray($data_series);
                
                // Overwrite Header
                $header = $this->buildHeaderMentee($fakultas);
                $sheet->row(1, $header);

            });
        })->export('xlsx');
    }

}
