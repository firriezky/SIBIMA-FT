<?php

namespace App\Http\Controllers\Mentor;

use App\Agenda;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PresensiTalaqiController extends Controller
{
    //
    public function index(){

        $presensi_talaqi = Auth::guard('mentor')->user()->getPresensiTalaqiSeries();
//        return response()->json($agendas);
        return view('mentor.kehadiran-talaqi', [
            'presensi_talaqi' => $presensi_talaqi
        ]);
    }
}
