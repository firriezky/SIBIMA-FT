<?php

namespace App\Http\Controllers\Mentee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelompokController extends Controller
{
    //
    public function index(){
        $kelompok = Auth::guard('mentee')->user()->getKelompok;
        return view('mentee.kelompok', [
            'kelompok' => $kelompok
        ]);
    }

//    public function detail($id){
//        return "id mentee " . $id;
//    }
}
