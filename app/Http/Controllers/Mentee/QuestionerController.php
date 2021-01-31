<?php

namespace App\Http\Controllers\Mentee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Questioner;

class QuestionerController extends Controller
{

	public function getQuestioner() {
        $list_questioner = Questioner::where('koresponden', 2)->paginate(5);
		return view('mentee.questioner', ["list_questioner" => $list_questioner]);
	}
	
}
