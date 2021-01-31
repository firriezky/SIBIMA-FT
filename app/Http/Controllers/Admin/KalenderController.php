<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KalenderController extends Controller
{
    public function viewKalender(){
        $events = Event::all(['title', 'start']);
//        $events->makeHidden('id');
//        $events->makeHidden('created_at');
//        $events->makeHidden('updated_at');

        return view('admin.kalender.kalender_icb', [
            'events' => $events
        ]);
    }

    public function index(){
        $events = Event::latest()->paginate(5);
        return view('admin.kalender.manage_event', [
            'events' => $events
        ]);
    }

    public function create(Request $request){
        $tanggal = Carbon::createFromFormat('d/m/Y H:i', $request->input('tanggal'));

        $event = new Event();
        $event->title = $request->input('nama');
        $event->start = $tanggal;
        $event->save();
        
        return redirect('admin/kalender/event');

    }

    public function delete($id){
        Event::destroy($id);
        flash('Event berhasil dihapus', 'success');
        return redirect('admin/kalender/event');
    }
}
