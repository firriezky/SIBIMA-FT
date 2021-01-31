<?php

namespace App\Http\Controllers\Mentee;

use App\Http\Controllers\Controller;
use App\Materi;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    //
    public function getMateri(){
        $list_materi = Materi::where('tipe', 2)->paginate(5);
        return view('mentee.materi', ["list_materi" => $list_materi]);
    }

}
