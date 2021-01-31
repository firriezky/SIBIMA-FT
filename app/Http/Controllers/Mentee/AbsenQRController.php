<?php

namespace App\Http\Controllers\Mentee;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenQRController extends Controller
{
    public function index()
    {
        $kelompok = Auth::guard('mentee')->user()->getKelompok;
        return view('mentee.absen', [
            'kelompok' => $kelompok
        ]);
    }
}
