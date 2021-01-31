<?php

namespace App\Http\Controllers\Mentor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Questioner;

class QuestionerController extends Controller
{

	public function getQuestioner() {
        $list_questioner = Questioner::where('koresponden', 1)->paginate(5);
		return view('mentor.questioner', ["list_questioner" => $list_questioner]);
	}
	
}
