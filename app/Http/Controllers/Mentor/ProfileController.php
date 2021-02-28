<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Utility;
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
}
