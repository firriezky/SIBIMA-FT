<?php

namespace App\Http\Controllers\Mentee;

use App\Event;
use App\Http\Controllers\Controller;
use App\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index() {

        // Ambil Data Event Kalender
        $events = Event::all(['title', 'start']);
        $kelompok = Auth::guard('mentee')->user()->getKelompok;

        // Get Data Pengumuman
        $pengumumans = Pengumuman::where('tipe', 2)->latest()->paginate(3);

        return view('mentee.dashboard', [
            'events' => $events,
            'kelompok' => $kelompok,
            'pengumumans' => $pengumumans
        ]);
    }

    public function redirect() {
        return redirect('mentee/dashboard');
    }
    
    public function about(){
        return view('mentee.about_bima');
    }

}