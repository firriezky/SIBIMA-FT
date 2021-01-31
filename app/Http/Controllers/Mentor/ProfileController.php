<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Utility;
use Illuminate\Support\Facades\URL;

class ProfileController extends Controller
{
    //
    public function getProfile(){
        return view('mentor.profile');
    }

    public function postProfile(Request $request){
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
