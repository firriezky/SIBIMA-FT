<?php

namespace App\Http\Controllers\Mentor;

use App\BeritaMentoring;
use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {

        // Ambil 5 Berita Mentoring terbaru
        $latest_berita_mentoring = BeritaMentoring::latest('id')
            ->take(5)
            ->get();

        // Ambil Data Event Kalender
        $events = Event::all(['title', 'start']);

        return view('mentor.dashboard',[
            "latest_berita_mentoring" => $latest_berita_mentoring,
            'events' => $events
        ]);
    }

    public function redirect() {
        return redirect('mentor/dashboard');
    }

    public function about(){
        return view('mentor.about_bima');
    }

}
