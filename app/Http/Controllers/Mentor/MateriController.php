<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Materi;

class MateriController extends Controller
{
    //
    public function getMateri(){
        $list_materi = Materi::where('tipe', 1)->paginate(5);
    	return view('mentor.materi', ["list_materi" => $list_materi]);
    }
}
