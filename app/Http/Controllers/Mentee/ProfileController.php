<?php

namespace App\Http\Controllers\Mentee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Utility;
use Illuminate\Support\Facades\URL;

class ProfileController extends Controller
{
    public function getProfile(){
    	return view('mentee.profile');
    }

    public function postProfile(Request $request){
    	$no_telp = $request->input('no_telp');
    	$line_id = $request->input('line_id');

    	$mentee = \app\Mentee::find(Auth::guard('mentee')->user()->id);
    	$mentee->no_telp = $no_telp;
    	$mentee->line_id = $line_id;
    	$mentee->save();

		flash("Save Profile Berhasil", "success");
		return redirect(URL::previous());
    }
}
