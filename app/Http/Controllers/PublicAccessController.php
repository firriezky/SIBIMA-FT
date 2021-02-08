<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect;
class PublicAccessController extends Controller
{
    public function mentorRegis()
    {
      return view('mentor');
    }
    public function mentorTeknik()
    {
        //SUDAH
        return Redirect::to("https://forms.gle/5Lbwd7yzawEcLahB9");
    }
    public function mentorFIK()
    {
        //SUDAH
        return Redirect::to("https://forms.gle/D3QTDNVTXVGQ1Ybm9");
    }
    public function mentorFKEB()
    {
        //SUDAH
        return Redirect::to("https://forms.gle/fympC6dMUaScEZzz6");
    }
    public function mentorFIT()
    {
        //SUDAH
        return Redirect::to("https://forms.gle/uW8GNU5kwPq62LfFA");
    }
}
