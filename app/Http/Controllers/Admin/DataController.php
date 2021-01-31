<?php

namespace App\Http\Controllers\Admin;
use App\Admin;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utility;

use App\Mentee;
use App\Mentor;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class DataController extends Controller
{

    //----------- MANAGE DATA MENTOR METHOD ---------------//

    public function listMentor(Request $request){

        $search = $request->input('search');
        $jk = 0;

        if ($request->has('jk')){
            $jk = $request->input('jk');
            $list_mentor = Mentor::where('jk', '=', $jk)
                ->whereRaw('(nim = ? or nama like ? or fakultas like ?)', [$search, '%'.$search.'%', '%'.$search.'%'])
                ->paginate(10);

        } else {
            $list_mentor = Mentor::where('nama', 'like', '%'.$search.'%')
                ->orWhere('fakultas', 'like', '%'.$search.'%')
                ->orWhere('nim', '=', $search)
                ->paginate(10);
        }

        $list_fakultas = DB::table('mentor')
            ->select('fakultas')
            ->distinct()->get();

        return view('admin.data.data_mentor', [
            "list_mentor" => $list_mentor,
            "search" => $search,
            "jk" => $jk,
            "list_fakultas" => $list_fakultas
        ]);
    }

    public function submitInputMentor(Request $request){
        $mentor = new Mentor();
        $mentor->nim = $request->input('nim');
        $mentor->nama = $request->input('nama');
        $mentor->password = Hash::make(Utility::$DEFAULT_MENTOR_PASSWORD);

        $mentor->fakultas = $request->input('fakultas');
        $mentor->jk = $request->input('jk');

        if ($request->input('no_telp') != "")
            $mentor->no_telp = $request->input('no_telp');

        if ($request->input('line_id') != "")
            $mentor->line_id = $request->input('line_id');

        $mentor->save();

        flash("Mentor berhasil di edit", 'success');
        return redirect('admin/data/mentor');

    }

    public function detailMentor($id){
        $mentor = Mentor::find($id);
        if ($mentor == null){
            flash("Mentor not found", 'danger');
            return redirect('admin/data/mentor/');
        } else {
            return view('admin.data.detail_mentor', ["mentor" => $mentor]);
        }
    }

    public function editMentor($id){
        $mentor = Mentor::find($id);
        if ($mentor == null){
            flash("Mentor not found", 'danger');
            return redirect('admin/data/mentor/');
        } else {

            $list_fakultas = DB::table('mentor')
                ->select('fakultas')
                ->distinct()->get();

            return view('admin.data.edit_mentor', [
                "mentor" => $mentor,
                "list_fakultas" => $list_fakultas
            ]);
        }
    }

    public function submitEditMentor(Request $request, $id){
        $mentor = Mentor::find($id);
        $mentor->nim = $request->input('nim');
        $mentor->nama = $request->input('nama');
        $mentor->fakultas = $request->input('fakultas');
        $mentor->jk = $request->input('jk');

        if ($request->input('no_telp') != "")
            $mentor->no_telp = $request->input('no_telp');

        if ($request->input('line_id') != "")
            $mentor->line_id = $request->input('line_id');

        $mentor->save();

        flash("Mentor berhasil di edit", 'success');
        return redirect('admin/data/mentor');
    }

    public function deleteMentor($id){
        Mentor::destroy($id);
        flash("Mentor berhasil di hapus", 'success');
        return redirect('admin/data/mentor');
    }

    public function resetPasswordMentor(Request $request){
        $mentor_id = $request->input('mentor_id');
        $reset_password = $request->input('password');
        $mentor = Mentor::find($mentor_id);
        $mentor->password = Hash::make($reset_password);
        $mentor->save();

        flash('Password berhasil direset', 'success');
        return redirect('admin/data/mentor');

    }

    //----------- MANAGE DATA MENTEE METHOD ---------------//

    public function listMentee(Request $request){
        $search = $request->input('search');
        $jk = 0;
        $fakultas_all = DB::table('mentee')->select('fakultas')->distinct()->get();
        $prodi_all = DB::table('mentee')->select('program_studi')->distinct()->get();
        $kelas_all = DB::table('mentee')->select('kelas')->distinct()->get();

        if($request->has('jk')){
            $jk = $request->input('jk');
            $list_mentee = Mentee::where('jk','=',$jk)
                ->whereRaw('(nim = ? or nama like ? or program_studi like ?)', [$search, '%'.$search.'%','%'.$search.'%'])
                ->paginate(10);
        } else{
            $list_mentee = Mentee::where('nama', 'like', '%'.$search.'%')
                ->orWhere('program_studi', 'like', '%'.$search.'%')
                ->orWhere('nim', '=', $search)
                ->paginate(10);
        }

        return view('admin.data.data_mentee', [
            "list_mentee" => $list_mentee,
            "search" => $search,
            "jk" => $jk,
            "fakultas_all" => $fakultas_all,
            "prodi_all" => $prodi_all,
            "kelas_all" => $kelas_all,
        ]);
    }

    public function submitInputMentee(Request $request){
        $mentee = new Mentee();
        $mentee->nim = $request->input('nim');
        $mentee->nama = $request->input('nama');
        $mentee->fakultas = $request->input('fakultas');
        $mentee->program_studi = $request->input('prodi');
        $mentee->kelas = $request->input('kelas');
        $mentee->jk = $request->input('jk');
        $mentee->password = Hash::make(Utility::$DEFAULT_MENTEE_PASSWORD);

        if ($request->input('no_telp') != "")
            $mentee->no_telp = $request->input('no_telp');

        if ($request->input('line_id') != "")
            $mentee->line_id = $request->input('line_id');

        $mentee->save();

        flash("Mentee berhasil di submit", 'success');
        return redirect('admin/data/mentee');
    }

    public function detailMentee($id){
        $mentee = Mentee::find($id);
        if ($mentee == null){
            flash("Mentee not found", 'danger');
            return redirect('admin/data/mentee/');
        } else {
            return view('admin.data.detail_mentee', ["mentee" => $mentee]);
        }

    }

    public function editMentee($id){
        $mentee = Mentee::find($id);
        $fakultas_all = DB::table('mentee')->select('fakultas')->distinct()->get();
        $prodi_all = DB::table('mentee')->select('program_studi')->distinct()->get();
        $kelas_all = DB::table('mentee')->select('kelas')->distinct()->get();

        return view('admin.data.edit_mentee', ["mentee" => $mentee,
                        "fakultas_all" => $fakultas_all,
                        "prodi_all" => $prodi_all,
                        "kelas_all" => $kelas_all
        ]);
    }

    public function submitEditMentee(Request $request, $id){
        $mentee = Mentee::find($id);
        $mentee->nim = $request->input('nim');
        $mentee->nama = $request->input('nama');
        $mentee->fakultas = $request->input('fakultas');
        $mentee->program_studi = $request->input('prodi');
        $mentee->kelas = $request->input('kelas');
        $mentee->jk = $request->input('jk');

        if ($request->input('no_telp') != "")
            $mentee->no_telp = $request->input('no_telp');

        if ($request->input('line_id') != "")
            $mentee->line_id = $request->input('line_id');

        $mentee->save();

        flash("Mentee berhasil di edit", 'success');
        return redirect('admin/data/mentee');
    }

    public function deleteMentee($id){
        Mentee::destroy($id);
        flash("Mentee berhasil di hapus", 'success');
        return redirect('admin/data/mentee');
    }

    public function resetPasswordMentee(Request $request){
        $mentee_id = $request->input('mentee_id');
        $reset_password = $request->input('password');
        $mentee = Mentee::find($mentee_id);
        $mentee->password = Hash::make($reset_password);
        $mentee->save();

        flash('Password berhasil direset', 'success');
        return redirect('admin/data/mentee');
    }

    //----------- MANAGE DATA ADMIN METHOD ---------------//

    public function listAdmin(){

        $list_admin = Admin::all();
        return view('admin.data.data_admin', [
            "list_admin" => $list_admin,
        ]);
    }

    //----------- UPLOAD CSV METHOD ---------------//

    public function viewUpload(){
        return view('admin.data.upload_data');
    }

    public function reformatData($results, $type){

        $arrlength = count($results);

        if ($type == "mentor") {
            // mentor default password
            $dummy_password =  Hash::make(Utility::$DEFAULT_MENTOR_PASSWORD);
        } else {
            // mentee default password
            $dummy_password =  Hash::make(Utility::$DEFAULT_MENTEE_PASSWORD);
        }
        $date_now = Carbon::now();

        // Rebuild Array, filling password, and date
        for($x = 0; $x < $arrlength; $x++) {
            $results[$x]['nama'] = strtoupper($results[$x]['nama']);
            $results[$x]['password'] = $dummy_password;
            $results[$x]['created_at'] = $date_now;
            $results[$x]['updated_at'] = $date_now;

            // Reformat Jenis Kelamin, akan raise exception jika tidak masuk kondisi ini
            if (strtolower($results[$x]['jk']) == "pria" or
                strtolower($results[$x]['jk']) == "laki-laki") {
                $results[$x]['jk'] = 1;
            }
            else if (strtolower($results[$x]['jk']) == "wanita" or
                strtolower($results[$x]['jk']) == "perempuan") {
                $results[$x]['jk'] = 2;
            }

            // TODO Reformat Fakultas dan Jurusan

        }

        return $results;

    }

    public function postUpload(Request $request){

        if ($request->hasFile('csv_mentee')) {

            try {

                $file = $request->file('csv_mentee');
                // CSV Process
                Excel::load($file, function($reader) {

                    $results = $reader->toArray();

                    // Rebuild Array, look at upper function
                    $results_data = $this->reformatData($results, "mentee");

                    // Multiple Insert Query
                    DB::table('mentee')->insert($results_data);

                });

                return Utility::response_js('Data Processing Success');

            } catch (QueryException $qe){
                return Utility::response_js('Already Upload / Duplicate Data / Wrong Format Data');
            } catch (\Exception $qe) {
                return Utility::response_js('File Unrecognized');
            }

        } else if ($request->hasFile('csv_mentor')) {

            try {
                $file = $request->file('csv_mentor');
                // CSV Process
                Excel::load($file, function($reader) {

                    $results = $reader->toArray();

                    $results_data = $this->reformatData($results, "mentor");

                    DB::table('mentor')->insert($results_data);

                });
                return Utility::response_js('Data Processing Success');

            } catch (QueryException $qe) {
                return Utility::response_js('Already Upload / Duplicate Data / Wrong Format Data');
            } catch (\Exception $qe) {
                return Utility::response_js('File Unrecognized');
            }

        } else {
            return Utility::response_js('File Not Found');
        }
    }

    //----------- MANAGE DB METHOD ---------------//

    public function viewManageDB(){
        try {

            $backup_path = base_path('storage/app/sibima-backup');

            // get latest backup
            $backup_collection = scandir($backup_path, 1);

        } catch (ErrorException $e) {
            $backup_collection = [];
        }

        return view('admin.data.manage_db', [
            "backup_collection" => $backup_collection
        ]);

    }

    public function remigrateDB(Request $request){

        if($request->input('password') == 'bahayabanget'){
            
            // delete public storage
            Storage::disk('public')->deleteDirectory('storage/');
            Storage::disk('public')->makeDirectory('storage/');


            // delete backup storage
            Storage::disk('local')->deleteDirectory('sibima-backup/');
            Storage::disk('local')->makeDirectory('sibima-backup/');

            // migrate database
            $remigrate = Artisan::call('migrate:refresh', ['--force' => true]);
            flash('Database berhasil di remigrate', 'success');

        } else{
            flash('Passwor salah!!', 'danger');
        }

        return redirect('admin/data/manage-db');
    }

    public function downloadBackup(Request $request){

        try {
            $backup_path = base_path('storage/app/sibima-backup');
            $file_name = $request->input('file_name');
            return response()->download($backup_path.'/'.$file_name);

        } catch (FileNotFoundException $fe){
            flash('File Backup not found', 'danger');
            return redirect('admin/data/manage-db');

        }

    }

    public function backupNow(){
        Artisan::call('backup:run');
        Artisan::call('backup:clean');
        flash('Backup Success', 'success');
        return redirect('admin/data/manage-db');
    }
}
