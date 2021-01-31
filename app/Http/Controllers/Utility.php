<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Utility extends Controller
{
    //
    public static function response_js($message, $url = ""){
        return "<script>".
            "alert('". $message ."');".
            "window.location.href='". $url ."';".
        "</script>";
    }
    
    public static $DEFAULT_MENTEE_PASSWORD = "mentee123";
    public static $DEFAULT_MENTOR_PASSWORD = "mentor123";

}
