<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Utility;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;

class ProfileController extends Controller
{
    public function export_excel()
    {
    }


    public function getData(Request $request)
    {

        $search = $request->input('search');
        $jk = 0;
        $paginate = 10;

        if ($request->has('showAll')) {
            $term_page = $request->input('showAll');
            if ($term_page = true) {
                $paginate = 999999999999;
            }
        }

        if ($request->has('paginate')) {
            $term_page = $request->input('paginate');
            if($term_page == "all" && is_numeric($term_page)){
                $paginate=999999999999;
            }
            $paginate = $term_page;
        }

        if ($request->has('jk')) {
            $jk = $request->input('jk');
            $list_mentor = Mentor::where('jk', '=', $jk)
                ->whereRaw('(nim = ? or nama like ? or fakultas like ?)', [$search, '%' . $search . '%', '%' . $search . '%'])
                ->paginate($paginate);
        } else {
            $list_mentor = Mentor::where('nama', 'like', '%' . $search . '%')
                ->orWhere('fakultas', 'like', '%' . $search . '%')
                ->orWhere('nim', '=', $search)
                ->paginate($paginate);
        }

        $list_fakultas = DB::table('mentor')
            ->select('fakultas')
            ->distinct()->get();

        return view('export.mentor', [
            "list_mentor" => $list_mentor,
            "search" => $search,
            "jk" => $jk,
            "list_fakultas" => $list_fakultas
        ]);
    }

    public function getProfile()
    {
        return view('mentor.profile');
    }

    public function postProfile(Request $request)
    {
        $nomor_hp = $request->input('nomor_hp');
        $id_line = $request->input('id_line');

        $mentor = Mentor::find(Auth::guard('mentor')->user()->id);
        $mentor->no_telp = $nomor_hp;
        $mentor->line_id = $id_line;
        $mentor->save();

        flash("Save Profile Berhasil", "success");
        return redirect(URL::previous());
    }


    public function postCredential(Request $request)
    {

        $rules = [
            "no_rekening"=>"required",
            'path_ktp' => 'image',
            'path_ktm' => 'image',
            'path_tabungan' => 'image',
            'is_lanjut' => 'required',
        ];
        
        $customMessages =[
            "required" => "Mohon isi field :attribute terlebih dahulu"
        ];

        $this->validate($request,$rules,$customMessages);

        $mentor = Mentor::find(Auth::guard('mentor')->user()->id);

        
        $pathKTM = $mentor->path_ktm;
        $pathKTP = $mentor->path_ktp;
        $pathTTD = $mentor->path_ktp;
        $pathTabungan = $mentor->path_rekening;


        if ($request->hasFile('photo_ktm')) {
            $file_path = public_path() . $mentor->path_ktm;
            if (file_exists($file_path)) {
                try {
                    unlink($file_path);
                } catch (Exception $e) {
                    // Do Nothing
                }
            }

            $file = $request->file('photo_ktm');
            $extension = $file->getClientOriginalExtension();
            $filename= $mentor->nim."-".time().".$extension";

            $savePath = "/web_files/ktm/$mentor->nim/";
            $savePathDB = "/web_files/ktm/$mentor->nim/$filename";
            $path = public_path()."$savePath";
            $file->move($path,$filename);
            $pathKTM = $savePathDB;
        }


        if ($request->hasFile('photo_ttd')) {
            $file_path = public_path() . $mentor->path_ttd;
            if (file_exists($file_path)) {
                try {
                    unlink($file_path);
                } catch (Exception $e) {
                    // Do Nothing
                }
            }

            $file = $request->file('photo_ttd');
            $extension = $file->getClientOriginalExtension();
            $filename= $mentor->nim."-".time().".$extension";

            $savePath = "/web_files/ttd/$mentor->nim/";
            $savePathDB = "/web_files/ttd/$mentor->nim/$filename";
            $path = public_path()."$savePath";
            $file->move($path,$filename);
            $pathTTD = $savePathDB;
        }


        if ($request->hasFile('photo_ktp')) {
            $file_path = public_path() . $mentor->path_ktp;
            if (file_exists($file_path)) {
                try {
                    unlink($file_path);
                } catch (Exception $e) {
                    // Do Nothing
                }
            }

            $file = $request->file('photo_ktp');
            $extension = $file->getClientOriginalExtension();
            $filename= $mentor->nim."-".time().".$extension";

            $savePath = "/web_files/ktp/$mentor->nim/";
            $savePathDB = "/web_files/ktp/$mentor->nim/$filename";
            $path = public_path()."$savePath";
            $file->move($path,$filename);
            $pathKTP = $savePathDB;
        }


        if ($request->hasFile('photo_tabungan')) {
            $file_path = public_path() . $mentor->path_ktp;
            if (file_exists($file_path)) {
                try {
                    unlink($file_path);
                } catch (Exception $e) {
                    // Do Nothing
                }
            }

            $file = $request->file('photo_tabungan');
            $extension = $file->getClientOriginalExtension();
            $filename= $mentor->nim."-".time().".$extension";

            $savePath = "/web_files/tabungan/$mentor->nim/";
            $savePathDB = "/web_files/tabungan/$mentor->nim/$filename";
            $path = public_path()."$savePath";
            $file->move($path,$filename);
            $pathTabungan = $savePathDB;
        }
       
        $mentor->no_rekening = $request->no_rekening;
        $mentor->is_lanjut=$request->is_lanjut;
        $mentor->path_rekening=$pathTabungan;
        $mentor->path_ktp=$pathKTP;
        $mentor->path_ttd=$pathTTD;
        $mentor->path_ktm=$pathKTM;
        $mentor->save();
        
        flash("Save Profile Berhasil", "success");
        return redirect(URL::previous());
    }
}
