<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelompokController extends Controller
{
    //
    public function index(){
        $list_kelompok = Auth::guard('mentor')->user()->getKelompok;

//        return response()->json($list_kelompok);
        return view('mentor.kelompok.kelompok', [
            "list_kelompok" => $list_kelompok
        ]);
    }
    
    public function asisten(){
        $list_kelompok = Auth::guard('mentor')->user()->getKelompokAsisten;

//        return response()->json($list_kelompok);
        return view('mentor.kelompok.kelompok_asisten', [
            "list_kelompok" => $list_kelompok
        ]);
    }
}
