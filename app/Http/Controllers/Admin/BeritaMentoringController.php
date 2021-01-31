<?php

namespace App\Http\Controllers\Admin;

use App\Agenda;
use App\BeritaMentoring;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utility;
use App\Kelompok;
use App\Mentee;
use App\Mentor;
use App\NilaiMentee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use InvalidArgumentException;
use Maatwebsite\Excel\Facades\Excel;

class BeritaMentoringController extends Controller
{
    //
    public function index(Request $request){

        $query = $request->input('search');
        $jk = $request->input('jk');

        // get agenda for input telat
        $agenda_mentoring = Agenda::where('tipe', 1)->get();

        if ($jk != null) {
            $list_berita_mentoring = BeritaMentoring::select('berita_mentoring.*', 'kelompok.kode as kode',
                'mentor.nama as mentor_nama', 'agenda.judul as judul')
                ->leftJoin('kelompok', 'berita_mentoring.kelompok_id', 'kelompok.id')
                ->leftJoin('mentor', 'kelompok.mentor_id', 'mentor.id')
                ->leftJoin('agenda', 'berita_mentoring.agenda_id', 'agenda.id')
                ->whereRaw('kelompok.type = ? and (kelompok.kode like ? or mentor.nama like ? or agenda.judul like ?)',
                    [$jk, '%'.$query.'%', '%'.$query.'%', '%'.$query.'%'])
                ->latest()
                ->paginate(10);
        } else {
            $list_berita_mentoring = BeritaMentoring::select('berita_mentoring.*', 'kelompok.kode as kode',
                'mentor.nama as mentor_nama', 'agenda.judul as judul')
                ->leftJoin('kelompok', 'berita_mentoring.kelompok_id', 'kelompok.id')
                ->leftJoin('mentor', 'kelompok.mentor_id', 'mentor.id')
                ->leftJoin('agenda', 'berita_mentoring.agenda_id', 'agenda.id')
                ->whereRaw('kelompok.kode like ? or mentor.nama like ? or agenda.judul like ?',
                    ['%'.$query.'%', '%'.$query.'%', '%'.$query.'%'])
                ->latest()
                ->paginate(10);

        }

        return view('admin.berita_mentoring.list_berita_mentoring', [
            "list_berita_mentoring" => $list_berita_mentoring,
            "agenda_mentoring" => $agenda_mentoring,
            "query" => $query,
            "jk" => $jk
        ]);
    }
    
    public function detail($id){
        $berita_mentoring = BeritaMentoring::find($id);
        if ($berita_mentoring == null){
            flash("Berita Mentoring not Found", 'danger');
            return redirect('admin/berita-mentoring');
        }
        return view('admin.berita_mentoring.detail_berita_mentoring', [
            "berita_mentoring" => $berita_mentoring,
        ]);
    }
    
    public function inputTelat(Request $request){

        if (!$request->has('mentor_nim') || !$request->has('agenda_id')) {
            // No request header
            return redirect('admin/berita-mentoring');
        }

        $mentor = Mentor::where('nim', $request->input('mentor_nim'))->first();
        $agenda = Agenda::find($request->input('agenda_id'));
        if ($mentor == null || $agenda == null || !($agenda->tipe == 1)) {
            flash('Agenda ID & NIM not found.', 'danger');
            return redirect('admin/berita-mentoring');
        } else if ($mentor->getKelompok->count() == 0){
            flash('Mentor tersebut belum mempunyai kelompok');
            return redirect('admin/berita-mentoring');
        } else if ($agenda->isAlreadyInput($mentor->id)){
            flash('Mentor tersebut sudah menginput Berita Mentoring pada Agenda yang dipilih', 'danger');
            return redirect('admin/berita-mentoring');
        } 

        $list_kelompok = $mentor->getKelompok;

        return view('admin.berita_mentoring.input_nilai_telat',[
            "agenda" => $agenda,
            "list_kelompok" => $list_kelompok
        ]);
    }

    public function submitTelat(Request $request){

        $list_mentee = $request->input('mentee_id');
        $list_nilai = $request->input('nilai');
        $list_kultum = $request->input('kultum');

        $kelompok = Kelompok::find($request->input('kelompok_id'));
        $count_mentee = count($kelompok->getMentee);

        $not_complete = false;
        if (count($list_mentee) != $count_mentee || count($list_kultum) != $count_mentee){
            $not_complete = true;
        } else {
            for ($i=0; $i < count($list_nilai); $i++){
                if ($list_nilai[$i] == null){
                    $not_complete = true;
                    break;
                }
            }
        }

        if ($not_complete){
            flash('Mohon penuhi semua form berita mentoring', 'danger');
            return redirect(URL::previous());
        }


        $berita_mentoring = new BeritaMentoring();
        $berita_mentoring->tempat = $request->input('tempat');
        $berita_mentoring->materi = $request->input('materi');
        $berita_mentoring->materi_kultum = $request->input('materi_kultum');
        try {
            $tanggal = Carbon::createFromFormat('d/m/Y H:i', $request->input('tanggal'));
        } catch (InvalidArgumentException $ex) {
            return Utility::response_js('Invalid format date');
        }
        $berita_mentoring->tanggal = $tanggal;
        $berita_mentoring->agenda_id = $request->input('agenda_id');
        $berita_mentoring->kelompok_id = $request->input('kelompok_id');
        $berita_mentoring->save();

        for ($i = 0; $i < count($list_mentee); $i++){
            $nilai = new NilaiMentee();
            $nilai->mentee_id = $list_mentee[$i];
            $nilai->berita_mentoring_id = $berita_mentoring->id;
            $nilai->kehadiran = $list_nilai[$i];
            $nilai->kultum = $list_kultum[$i];
            $nilai->save();
        }

        flash('Berita Mentoring berhasil di-input', 'success');
        return redirect('admin/berita-mentoring');

    }

    public function edit($id){

        $berita_mentoring = BeritaMentoring::find($id);

        if ($berita_mentoring == null){
            flash("Berita Mentoring not Found", 'danger');
            return redirect('admin/berita-mentoring');
        }

        $agenda = Agenda::find($berita_mentoring->agenda_id);
        $kelompok = Kelompok::find($berita_mentoring->kelompok_id);

        return view('admin.berita_mentoring.edit', [
            "berita_mentoring" => $berita_mentoring,
            "agenda" => $agenda,
            "kelompok" => $kelompok
        ]);

    }

    public function submitEdit(Request $request, $id){

        $berita_mentoring = BeritaMentoring::find($request->input('berita_mentoring_id'));
        $berita_mentoring->tempat = $request->input('tempat');
        $berita_mentoring->materi = $request->input('materi');
        $berita_mentoring->materi_kultum = $request->input('materi_kultum');
        $berita_mentoring->save();

        $list_id = $request->input('nilai_id');
        $list_nilai = $request->input('nilai');
        $list_kultum = $request->input('kultum');

        for ($i = 0; $i < count($list_id); $i++){
            $nilai = NilaiMentee::find($list_id[$i]);
            $nilai->kehadiran = $list_nilai[$i];
            $nilai->kultum = $list_kultum[$i];
            $nilai->save();
        }

        flash('Berita Mentoring berhasil di-edit', 'success');
        return redirect('admin/berita-mentoring');


    }

    public function unreported(Request $request){

        $query = $request->input('search');
        $agenda_mentoring = Agenda::where('tipe', 1)->get();

        if ($request->has('agenda')){
            $list_unreported = Kelompok::select('kelompok.*', 'agenda.judul as judul', 'bm.id as bm_id')
                ->crossJoin('agenda')
                ->leftJoin('berita_mentoring as bm', function($join){
                    $join->on('agenda.id', '=', 'bm.agenda_id');
                    $join->on('bm.kelompok_id', '=', 'kelompok.id');
                })
                ->leftJoin('mentor', 'kelompok.mentor_id', 'mentor.id')
                ->whereRaw('(bm.id is null and agenda.id = ?) and (kelompok.kode = ? or mentor.nama like ?)',
                    [$request->input('agenda'), $query , '%'.$query.'%'])
                ->paginate(10);


        } else {
            $list_unreported = Kelompok::select('kelompok.*', 'agenda.judul as judul', 'bm.id as bm_id')
                ->crossJoin('agenda')
                ->leftJoin('berita_mentoring as bm', function($join){
                    $join->on('agenda.id', '=', 'bm.agenda_id');
                    $join->on('bm.kelompok_id', '=', 'kelompok.id');
                })
                ->leftJoin('mentor', 'kelompok.mentor_id', 'mentor.id')
                ->whereRaw('(bm.id is null and agenda.tipe = 1) and (kelompok.kode = ? or mentor.nama like ?)',
                    [$query, '%'.$query.'%'])
                ->paginate(10);
        }

//        print_r($list_unreported->toArray());
        return view('admin.berita_mentoring.unreported', [
            "list_unreported" => $list_unreported,
            "agenda_mentoring" => $agenda_mentoring,
            "current_agenda" => $request->input('agenda'),
            "query" => $query
        ]);
    }

    public function delete(Request $request, $id){
        if ($request->input("password") == "bahayabanget"){
            BeritaMentoring::destroy($id);
            flash('Berita Mentoring berhasil di delete.', 'success');
        } else {
            flash('Password Salah!!.', 'danger');
        }
        return redirect('admin/berita-mentoring');

    }
}
