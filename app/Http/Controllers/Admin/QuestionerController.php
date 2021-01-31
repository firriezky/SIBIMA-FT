<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Questioner;

class QuestionerController extends Controller
{

	public function index() {
        $list_questioner = Questioner::paginate(10);
		return view('admin.questioner', ["list_questioner" => $list_questioner]);
	}
	
    public function addQuestioner(Request $request){
    	$judul = $request->input('judul');
    	$link = $request->input('link');
    	$koresponden = $request->input('koresponden');

    	$new_questioner = new Questioner();
    	$new_questioner->judul = $judul;
    	$new_questioner->link = $link;
    	$new_questioner->koresponden = $koresponden;
    	$new_questioner->save();

 		return redirect('admin/questioner');
    }

    public function deleteQuestioner($id){
        $questioner = Questioner::find($id);
        $questioner->delete();
        flash('Questioner berhasil di hapus', 'success');
        return redirect('admin/questioner');
    }
}
