<?php

namespace App\Http\Controllers\Mentor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pengumuman;

class PengumumanController extends Controller
{
    public function viewPengumuman(){
    	$list_pengumuman = Pengumuman::where('tipe', 1)->latest()->paginate(3);

    	return view('mentor.pengumuman',['list_pengumuman' => $list_pengumuman]);
    }
}
