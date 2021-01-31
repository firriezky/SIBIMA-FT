<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getLogin(){
        if(Auth::guard('admin')->check())
            return redirect('/admin');
        else if(Auth::guard('mentee')->check())
            return redirect('/mentee');
        else if(Auth::guard('mentor')->check())
            return redirect('/mentor');
        else
            return view('login');
    }

    public function submitLogin(Request $request){

        if(Auth::guard('admin')->attempt(['username' => $request['nim'], 'password' => $request['password']])){
            return redirect('/admin');

        } else if(Auth::guard('mentee')->attempt(['nim' => $request['nim'], 'password' => $request['password']])) {
            return redirect('/mentee');

        } else if(Auth::guard('mentor')->attempt(['nim' => $request['nim'], 'password' => $request['password']])) {
            return redirect('/mentor');

        } else {
            flash("NIM atau Password salah", "danger");
            return redirect('/login');
        }
    }

    public function logout(){
        Auth::guard('admin')->logout();
        Auth::guard('mentee')->logout();
        Auth::guard('mentor')->logout();
        return redirect('/');
    }
}
