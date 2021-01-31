<?php

namespace App\Http\Controllers\Mentor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;

class PasswordController extends Controller
{
	public function getPassword(){
		return view('mentor.password');
	}
    
    public function changePassword(Request $request){
        $password_baru = $request->input('password-baru');
        $password_lama = $request->input('password-lama');
        $re_enter = $request->input('re-enter');
        $mentor = \app\Mentor::find(Auth::guard('mentor')->user()->id);
        $hashedPassword = $mentor->password;
        if(Hash::check($password_lama, $hashedPassword)){
            if($password_baru == $re_enter){
                $mentor->password = Hash::make($password_baru);
                $mentor->save();
                flash("Password berhasil diubah", "success");
                return redirect(URL::previous());
            }
            else {
                flash("Password baru tidak sesuai dengan yang diketik ulang", "danger");
                return redirect(URL::previous());
            }
        }
        else {
            flash("Password lama tidak sesuai", "danger");
            return redirect(URL::previous());

        }
    }
}
