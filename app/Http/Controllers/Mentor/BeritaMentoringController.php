<?php

namespace App\Http\Controllers\Mentor;

use App\BeritaMentoring;
use App\Http\Controllers\Utility;
use App\Kelompok;
use App\Mentee;
use App\NilaiMentee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Agenda;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use InvalidArgumentException;
use Knp\Snappy\Pdf;

class BeritaMentoringController extends Controller
{
    public function getListAgenda(){
        $agendas = Agenda::where('tipe', 1)->get();
        return view('mentor.berita_mentoring.agenda_list', ['agendas' => $agendas]);
    }
    
    public function input($id_agenda){

        $agenda = Agenda::find($id_agenda);

        // Kondisi Agenda not found
        if ($agenda == null || ! ($agenda->tipe == 1)){
            flash("Agenda Mentoring Not Found.", 'danger');
            return redirect('mentor/berita-mentoring/');
        }

        // Kondisi Telat Input Agenda / isEnded()
        if ($agenda->isEnded()){
            flash("Agenda sudah berakhir", 'danger');
            return redirect('mentor/berita-mentoring/');
        }

        // Kondisi Agenda sudah diinput
        if ($agenda->isAlreadyInput(Auth::guard('mentor')->user()->id)){
            flash("Agenda Sudah Diinput.", 'info');
            return redirect('mentor/berita-mentoring/');
        }

        $list_kelompok = Auth::guard('mentor')->user()->getKelompok;

        return view('mentor.berita_mentoring.input-nilai', [
            "list_kelompok" => $list_kelompok,
            "agenda" => $agenda
        ]);
    }

    public function submit(Request $request, $id_agenda){
        $list_mentee = $request->input('mentee_id');
        $list_nilai = $request->input('nilai');
        $list_kultum = $request->input('kultum');

        $kelompok = Kelompok::find($request->input('kelompok_id'));
        $agenda = Agenda::find($id_agenda);

        $groupName = $kelompok->kode;
        $agendaName = $agenda->judul;
        
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
        $filename = "";
        //If File Exist
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileExtension = $file->getClientOriginalExtension();
            $directory = "BERITA_MENTORING/".$agendaName."/".$groupName."/";
            $filename = time()."_.".$fileExtension;
            //Save FILE to Folder
            Input::file('photo')->move(public_path($directory),$filename);
        }else{
            flash('Mohon isi bukti foto mentoring general', 'danger');
            return redirect(URL::previous());
        }

        $berita_mentoring->photo = "$filename";
        $berita_mentoring->materi = $request->input('materi');
        $berita_mentoring->materi_kultum = $request->input('materi_kultum');
        
        try {
            $tanggal = Carbon::createFromFormat('d/m/Y H:i', $request->input('tanggal'));
        } catch (InvalidArgumentException $ex) {
            flash('Invalid format date', 'danger');
            return redirect('mentor/berita-mentoring');
        }

        $berita_mentoring->tanggal = $tanggal;
        $berita_mentoring->record_gmeet = $request->gmeet_record;
        $berita_mentoring->agenda_id = $id_agenda;
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
        return redirect('mentor/berita-mentoring');

    }

    public function edit($id_agenda){

        $mentor = Auth::guard('mentor')->user();
        $agenda = Agenda::find($id_agenda);

        // Kondisi Agenda not found
        if ($agenda == null || ! ($agenda->tipe == 1)){
            flash("Agenda Mentoring Not Found.", 'danger');
            return redirect('mentor/berita-mentoring/');

        // Kondisi Telat Input Agenda / isEnded()
        }else if ($agenda->isEnded()){
            flash("Agenda sudah berakhir", 'danger');
            return redirect('mentor/berita-mentoring/');

        } elseif ($agenda->isAlreadyInput($mentor->id)) {

            // Get Kelompok Data
            $list_kelompok = $mentor->getKelompok;
            flash('Anda mempunyai waktu pengeditan Berita Mentoring sampai Agenda terkait berakhir.', 'info');
            return view('mentor.berita_mentoring.edit-nilai', [
                "list_kelompok" => $list_kelompok,
                "agenda" => $agenda
            ]);

        } else {
            // Redirect Nilai Belum Terinput
            return redirect('mentor/berita-mentoring/input/' . $id_agenda);
        }

    }
    
    public function submitEdit(Request $request, $id_agenda){

        if (Agenda::find($id_agenda)->isEnded()){
            flash("Agenda sudah berakhir", 'danger');
            return redirect('mentor/berita-mentoring/');
        }

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
        return redirect('mentor/berita-mentoring');

    }

    public function rekap(){
        $list_kelompok = Auth::guard('mentor')->user()->getKelompok;
        $agenda_mentoring = Agenda::where('tipe', 1)->get();
//        $agenda_general = Agenda::where('tipe', 1)->get();

        return view('mentor.berita_mentoring.rekap', [
            "list_kelompok" => $list_kelompok,
            "agenda_mentoring" => $agenda_mentoring
        ]);

//        return Mentee::where('nim', '1402160126')->first()->getNilaiMentoringSeries();
    }

    public function export($id_agenda)
    {

        // Handler agenda not found
        $agenda = Agenda::find($id_agenda);
        if ($agenda == null || $agenda->tipe != 1){
            flash("can't generate files, agenda not found or wrong", 'danger');
            return redirect("mentor/berita-mentoring");
        }

        //
        $mentor = Auth::guard('mentor')->user();

        $list_kelompok = $mentor->getKelompok;

        $pdf = \SnappyPDF::loadView('mentor.berita_mentoring.export_view', [
            "list_kelompok" => $list_kelompok,
            "agenda_mentoring" => $agenda
        ]);

        $file_name = "BeritaMentoring_" . $agenda->judul . "_" . $mentor->nim . "_SIBIMA.pdf";
        return $pdf->download($file_name);


    }


}
