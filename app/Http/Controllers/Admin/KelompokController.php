<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utility;
use App\Kelompok;
use App\Mentee;
use App\Mentor;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Psy\Exception\ErrorException;
use SebastianBergmann\CodeCoverage\Util;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;


class KelompokController extends Controller
{
    public function listKelompok(Request $request)
    {

        $search = $request->input('search');
        $jk = $request->input('jk');

        if ($request->has('jk')){
            $jk = $request->input('jk');
            $list_kelompok = Kelompok::select('kelompok.*')
                ->leftJoin('mentor as mentor', 'mentor_id', 'mentor.id')
                ->leftJoin('mentor as asisten', 'asisten_id', 'asisten.id')
                ->where('type', '=', $jk)
                ->whereRaw('(kode = ? or mentor.nama like ? or asisten.nama like ?)', [$search, '%'.$search.'%', '%'.$search.'%'])
                ->paginate(10);

        } else {
            $list_kelompok = Kelompok::select('kelompok.*')
                ->leftJoin('mentor as m', 'mentor_id', 'm.id')
                ->leftJoin('mentor as a', 'asisten_id', 'a.id')
                ->where('m.nama', 'like', '%'.$search.'%')
                ->orWhere('a.nama', 'like', '%'.$search.'%')
                ->orWhere('kode', '=', $search)
                ->paginate(10);
        }

        return view('admin.kelompok.kelompok_list', [
            "list_kelompok" => $list_kelompok,
            "search" => $search,
            "jk" => $jk,
        ]);
    }

    public function detailKelompok($id){

        $kelompok = Kelompok::find($id);
        if ($kelompok != null) {
            return view('admin.kelompok.kelompok_manage', [
                "kelompok" => $kelompok
            ]);

        } else {
            flash("Kelompok Not Found", 'danger');
            return redirect(URL::previous());
        }

    }

    // Method Handling Kelompok Ikhwan
    public function createIkhwan()
    {

        $program_study = DB::table('mentee')
            ->select('program_studi')
            ->groupBy('program_studi')
            ->get();

        // Use Eloquent for Calling Method
//        $list_mentor = Mentor::select('id', 'nama', 'fakultas')
//            ->where('jk', 1)
//            ->get();

        $list_mentor = Mentor::allMentorCounterMentor(1);
        $list_asisten = Mentor::allMentorCounterAsisten(1);

        return view('admin.kelompok.kelompok_create_ikhwan', [
            "jurusan" => $program_study,
            'list_mentor' => $list_mentor,
            'list_asisten' => $list_asisten,
        ]);
    }

    public function postCreateIkhwan(Request $request) {

        try {
            // Retrieve Data Input
            $mentor_id = intval($request->input('mentor'));
            $asisten_id = intval($request->input('asisten'));
            $list_mentee = $request->input('mentee');

            if ($mentor_id == $asisten_id){
                flash('Asisten dan Mentor tidak boleh sama.', 'danger');
                return redirect('admin/kelompok/create-ikhwan');
            }

            $new_kelompok = new Kelompok();
            $new_kelompok->mentor_id = $mentor_id;
            if ($asisten_id != 0) {
                $new_kelompok->asisten_id = $asisten_id;
            }

            $id = DB::table('kelompok_it')->insertGetId([]);
            $new_kelompok->kode = "IT-" . $id;
            $new_kelompok->type = 1;

            $new_kelompok->save();

            // Assign Setiap Mentor ke Kelompok
            for ($x = 0; $x < count($list_mentee); $x++) {
                $mentee = Mentee::find($list_mentee[$x]);
                $mentee->kelompok_id = $new_kelompok->id;
                $mentee->save();
            }

            flash('Kelompok berhasil dibuat', 'success');

            return redirect('admin/kelompok/create-ikhwan');

        } catch (QueryException $qe) {

            flash('Kelompok gagal dibuat (tolong pilih mentor & mentee)', 'danger');

            return redirect('admin/kelompok/create-ikhwan');

        }

    }

    public function apiGetKelas(Request $request){

        // FUCK OF QUERY - TODO : CHECK & UPGRADE PERFORMANCE
        $jurusan = $request->input('jurusan');
        $kelas = DB::table('mentee')
            ->select('kelas')
            ->where('program_studi', '=', $jurusan)
            ->groupBy('kelas')
            ->orderBy('kelas', 'asc')
            ->get();

        return response()->json($kelas);
    }

    public function apiGetMenteeIkhwan(Request $request){

        // FUCK OF QUERY - TODO : CHECK & UPGRADE PERFORMANCE

        $kelas = $request->input('kelas');
        $mentee = DB::table('mentee')
            ->select('nama as mentee', 'nim', "id")
            ->where('kelas', '=', $kelas)
            ->where('kelompok_id', '=', null)
            ->where('jk', '=', 1)
            ->orderBy('nim', 'asc')
            ->get();

        return response()->json($mentee);

    }

    // Method Handling Kelompok Akhwat
    public function createAkhwat()
    {

        $program_study = DB::table('mentee')
            ->select('program_studi')
            ->groupBy('program_studi')
            ->get();

        // Use Eloquent for Calling Method
//        $list_mentor = Mentor::select('id', 'nama', 'fakultas')
//            ->where('jk', 2)
//            ->get();
        $list_mentor = Mentor::allMentorCounterMentor(2);
        $list_asisten = Mentor::allMentorCounterAsisten(2);


        return view('admin.kelompok.kelompok_create_akhwat', [
            "jurusan" => $program_study,
            'list_mentor' => $list_mentor,
            'list_asisten' => $list_asisten
        ]);
    }

    public function postCreateAkhwat(Request $request) {

        try {
            // Retrieve Data Input
            $mentor_id = intval($request->input('mentor'));
            $asisten_id = intval($request->input('asisten'));
            $list_mentee = $request->input('mentee');

            if ($mentor_id == $asisten_id){
                flash('Asisten dan Mentor tidak boleh sama.', 'danger');
                return redirect('admin/kelompok/create-akhwat');
            }

            $new_kelompok = new Kelompok();
            $new_kelompok->mentor_id = $mentor_id;
            if($asisten_id != 0){
                $new_kelompok->asisten_id = $asisten_id;
            }

            $id = DB::table('kelompok_at')->insertGetId([]);
            $new_kelompok->kode = "AT-" . $id;
            $new_kelompok->type = 2; //wanita type 2

            $new_kelompok->save();

            // Assign Setiap Mentee ke Kelompok
            for ($x = 0; $x < count($list_mentee); $x++) {
                $mentee = Mentee::find($list_mentee[$x]);
                $mentee->kelompok_id = $new_kelompok->id;
                $mentee->save();
            }

            flash('Kelompok berhasil dibuat', 'success');

            return redirect('admin/kelompok/create-akhwat');

        } catch (QueryException $qe) {

            flash('Kelompok gagal dibuat (tolong pilih mentor & mentee)', 'danger');

            return redirect('admin/kelompok/create-akhwat');

        }
    }

    public function apiGetMenteeAkhwat(Request $request){

        // FUCK OF QUERY - TODO : CHECK & UPGRADE PERFORMANCE

        $kelas = $request->input('kelas');
        $mentee = DB::table('mentee')
            ->select('nama as mentee', 'nim', "id")
            ->where('kelas', '=', $kelas)
            ->where('kelompok_id', '=', null)
            ->where('jk', '=', 2)
            ->orderBy('nim', 'asc')
            ->get();

//        print_r($mentee);
//        sleep(1);
        return response()->json($mentee);

    }

    // Validasi Kelompok
    public function validasi(){
        $mentee_belum_berkelompok = Mentee::where('kelompok_id', null)
            ->select('nim', 'nama', 'kelas', 'jk')
            ->paginate(50);

            $menteeCount = Mentee::where('kelompok_id', null)
            ->select('nim', 'nama', 'kelas', 'jk')
            ->count();

            $mentorCount = DB::table('mentor')
            ->select('mentor.nama', 'mentor.nim', 'mentor.fakultas', 'mentor.jk')
            ->leftJoin('kelompok', 'mentor.id', 'kelompok.mentor_id')
            ->where('kelompok.mentor_id', null)
            ->count();

        $mentor_belum_berkelompok = DB::table('mentor')
            ->select('mentor.nama', 'mentor.nim', 'mentor.fakultas', 'mentor.jk')
            ->leftJoin('kelompok', 'mentor.id', 'kelompok.mentor_id')
            ->where('kelompok.mentor_id', null)
            ->paginate(50);

        return view('admin.kelompok.validasi', [
            "menteeCount" => $menteeCount,
            "mentorCount" => $mentorCount,
            "mentee_belum_berkelompok" => $mentee_belum_berkelompok,
            "mentor_belum_berkelompok" => $mentor_belum_berkelompok
        ]);
    }

    public function deleteKelompok($id){
        Kelompok::destroy($id);
        flash('Kelompok Berhasil di Hapus', 'success');
        return redirect('admin/kelompok');
    }
    
    public function removeMentee($id_mentee){
        $mentee = Mentee::find($id_mentee);
        if ($mentee != null) {
            $mentee->kelompok_id = null;
            $mentee->save();
            flash('Mentee berhasil dihapus dari Kelompok', 'success');

        } else {
            flash('Mentee not found', 'danger');
        }

        // Pindah Mentee nilai tidak dihapus

        return redirect(URL::previous());
    }

    public function addMentee($id, Request $request){
        $mentee = Mentee::where('nim', $request->input('nim'))->first();

        $kelompok = Kelompok::find($id);

        if ($mentee != null && $kelompok != null){

            if ($mentee->kelompok_id == null){

                if ($mentee->jk == $kelompok->type){

                    $mentee->kelompok_id = $id;
                    $mentee->save();
                    flash('Mentee berhasil ditambahkan ke Kelompok', 'success');

                } else {
                    flash('JK mentee tidak sesuai dengan Tipe Kelompok', 'danger');

                }

            } else {
                flash('Mentee tersebut berada di kelompok lain, harap remove dulu', 'warning');
            }


        } else {
            flash('FAILED, Mentee dengan NIM yang diinput tidak ditemukan / Kelompok Not Found', 'danger');
        }

        return redirect(URL::previous());
    }

    public function changeMentorOrAsisten(Request $request, $id){
        
        $kelompok = Kelompok::find($id);

        if ($kelompok == null){
            flash("Kelompok not found", "danger");
            return redirect(URL::previous());
        }

        if ($request->has('mentor_nim')){

            $mentor = Mentor::where('nim', $request->input('mentor_nim'))->first();
            if ($mentor == null){
                flash('NIM Mentor yang diinput tidak ditemukan', 'danger');
                return redirect(URL::previous());
            } else {

                if ($mentor->jk != $kelompok->type){
                    flash('Mentor dan Anggota Kelompok tidak boleh bebeda JK', 'danger');
                    return redirect(URL::previous());

                } else {
                    $kelompok->mentor_id = $mentor->id;
                    $kelompok->save();
                    flash('Pergantian Mentor Berhasil', 'success');
                    return redirect(URL::previous());

                }

            }

        } elseif ($request->has('asisten_nim')){

            $asisten = Mentor::where('nim', $request->input('asisten_nim'))->first();
            if ($asisten == null){
                flash('NIM Asisten yang diinput tidak ditemukan', 'danger');
                return redirect(URL::previous());
            } else {

                if ($asisten->jk != $kelompok->type) {
                    flash('Asisten dan Anggota Kelompok tidak boleh bebeda JK', 'danger');
                    return redirect(URL::previous());
                } else {
                    $kelompok->asisten_id = $asisten->id;
                    $kelompok->save();
                    flash('Pergantian Asisten Berhasil', 'success');
                    return redirect(URL::previous());
                }
            }


        } else {
            return redirect(URL::previous());
        }
    }
    
    //*** Export Kelompok to Excel***
    public function buildHeaderKelompok(){
        $header = ['Kelompok', 'NIM', 'Nama', 'JK', 'Kelas', 'Prodi', 'No_HP'];
        //add header Mentor
        array_push($header, 'Mentor');
        array_push($header, 'Kontak');
        //add header Mentee
        array_push($header, 'Asisten');
        array_push($header, 'Kontak');
        return $header;
    }

    public function buildRowKelompok($mentee){
        $row = array();

        //Add kelompok column
        $kelompok = $mentee->getKelompok;
        if($kelompok == null) array_push($row, "NULL");
        else array_push($row, $kelompok->kode);

        //Add data diri column(Nim, nama, jk, kelas)
        array_push($row, $mentee->nim);
        array_push($row, $mentee->nama);
        array_push($row, $mentee->getJK());
        array_push($row, $mentee->kelas);
        array_push($row, $mentee->program_studi);
        array_push($row, $mentee->no_telp);

        //Add Mentor column
        $mentor = $kelompok->getMentor;
        array_push($row, $mentor->nama);
        array_push($row, $mentor->no_telp . " " . $mentor->line_id);

        //Add Asisten column
        $asisten = $kelompok->getAsisten;
        if ($asisten != null){
            array_push($row, $asisten->nama);
            array_push($row, $asisten->no_telp . " " . $asisten->line_id);
        } else {
            array_push($row, "-");
            array_push($row, "-");
        }

        return $row;
    }

    public function exportKelompok(){
        $list_prodi = DB::table('mentee')
            ->select('program_studi')
            ->distinct()->get();

        $list_fakultas = DB::table('mentee')
            ->select('fakultas')
            ->distinct()->get();

        return view('admin.kelompok.export_kelompok', [
            'list_prodi' => $list_prodi,
            'list_fakultas' => $list_fakultas,
        ]);
    }

    public function exportData(Request $request){
        $jk = $request->input('jk');

        if($jk == 1) {
            $list_kelompok = Kelompok::where('type', 1)->get();
            $jenis = "Ikhwan";
        } else if($jk == 2) {
            $list_kelompok = Kelompok::where('type', 2)->get();
            $jenis = "Akhwat";
        } else {
            $list_kelompok = null;
            $jenis = "NULL";
        }

        //data that will insert to the sheet
        $data = array();

        if($request->has('fakultas')){
            $query = $request->input('fakultas');

            foreach($list_kelompok as $kelompok){
                $mentees = $kelompok->getMentee()
                                ->where('fakultas', $query)
                                ->orderBy('kelas','asc')
                                ->get();
                //make mentee row with the same fakultas
                foreach($mentees as $mentee){
                    $row = $this->buildRowKelompok($mentee);
                    array_push($data, $row);
                }
            }
        }
        else if($request->has('prodi')){
            $query = $request->input('prodi');
            foreach($list_kelompok as $kelompok){
                $mentees = $kelompok->getMentee()
                                ->where('program_studi', $query)
                                ->orderBy('kelas', 'asc')
                                ->get();
                //make mentee row with the same prodi
                foreach($mentees as $mentee){
                    $row = $this->buildRowKelompok($mentee);
                    array_push($data, $row);
                }
            }
        }

        //Export to Excel
        Excel::create('kelompok_' . strtolower($query) . "_" . strtolower($jenis) . "_" . Carbon::now()->toDateString(),
            function($excel) use ($data){
                $excel->sheet('Sheetname', function($sheet) use ($data){

                    //overwrite header
                    $sheet->fromArray($data);

                    //overwrite header
                    $header = $this->buildHeaderKelompok();
                    $sheet->row(1, $header);

            });
        })->export('xlsx');
    }
    
    // Generate Kelompok
    public function generate(Request $request){

        // Retrieve Query Data
        $fakultas_mentee = $request->input('fakultas_mentee');
        $fakultas_mentor = $request->input('fakultas_mentor');
        $batas = $request->input('batas');
        $jk = $request->input('jk');

        if ($request->has('fakultas_mentee') && $request->has('fakultas_mentor')
            && $request->has('jk') && $request->has('batas')){

            $list_mentee = Mentee::where('jk', $jk)
                ->where('kelompok_id', null)
                ->where('fakultas', $fakultas_mentee)
                ->orderBy('kelas')
                ->get();

            $list_mentor = Mentor::where('jk',$jk)
                ->where('fakultas', $fakultas_mentor)
                ->get();

            $iter_mentor = 0;
            $iter_mentee = 0;
            $max_mentor = count($list_mentor);

            // Build Kelompok
            $kelompok = new Kelompok();
            $kelompok->mentor_id = $list_mentor[$iter_mentor]->id;
            $iter_mentor++;
            if ($jk == 1){
                $id_kelompok = DB::table('kelompok_it')->insertGetId([]);
                $kelompok->kode = "IT-" . $id_kelompok;
                $kelompok->type = 1;

            } else {
                $id_kelompok = DB::table('kelompok_at')->insertGetId([]);
                $kelompok->kode = "AT-" . $id_kelompok;
                $kelompok->type = 2;
            }
            $kelompok->save();

            foreach ($list_mentee as $mentee){

                // Jika Melebihi batas kelompok
                // maka buat kelompok baru
                if ($iter_mentee >= $batas){
                    
                    // Build Kelompok
                    $kelompok = new Kelompok();
                    $kelompok->mentor_id = $list_mentor[$iter_mentor]->id;
                    $iter_mentor++;
                    
                    if ($jk == 1){
                        $id_kelompok = DB::table('kelompok_it')->insertGetId([]);
                        $kelompok->kode = "IT-" . $id_kelompok;
                        $kelompok->type = 1;

                    } else {
                        $id_kelompok = DB::table('kelompok_at')->insertGetId([]);
                        $kelompok->kode = "AT-" . $id_kelompok;
                        $kelompok->type = 2;

                    }

                    $kelompok->save();
                    $iter_mentee = 0;

                }

                $mentee->kelompok_id = $kelompok->id;
                $mentee->save();
                $iter_mentee++;

                // Jika mentor sudah semua berkelompok
                // maka re-assign kembali mentor sebelumnya
                if ($iter_mentor >= $max_mentor){
                    $iter_mentor = 0;
                }

            }

            flash("Kelompok has been successfullly generate", 'success');
            return redirect('admin/kelompok/generate');

        } else {

            $list_fakultas_mentee = DB::table('mentee')
                ->select('fakultas', DB::raw("count(fakultas) as count"))
                ->whereNull('kelompok_id')
                ->groupBy('fakultas')
                ->get();

            $list_fakultas_mentor = DB::table('mentor')
                ->select('fakultas', DB::raw("count(fakultas) as count"))
                ->groupBy('fakultas')
                ->get();

            return view('admin.kelompok.generate', [
                'list_fakultas_mentee' => $list_fakultas_mentee,
                'list_fakultas_mentor' => $list_fakultas_mentor,
            ]);
        }
    }

    public function processGenerate(Request $request){

        $fakultas = $request->input('fakultas');

    }
}