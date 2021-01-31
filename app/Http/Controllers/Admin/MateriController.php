<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\RootViolationException;
use Psy\Exception\ErrorException;

class MateriController extends Controller
{
    //
    public function index(){
        $list_materi = Materi::paginate(10);
        return view('admin.materi', [
            'list_materi' => $list_materi
        ]);
    }
    
    public function create(Request $request){
        $nama = $request->input('judul');
        $file = $request->file('materi');
        
        $materi = new Materi();
        $materi->nama = $nama;
        $materi->tipe = $request->input('tipe');
        $materi->file_url = "";
        $materi->save();

        try {
            $path = $file->storeAs('storage/materi/' . $materi->id, $file->getClientOriginalName(), 'public');
            $materi->file_url = $path;
            $materi->save();

            flash('Materi upload success');

        } catch (\Exception $ex){
            flash('Materi upload failed, limit file exceeded');
            $materi->delete();

        }

        return redirect('admin/materi');
    }

    public function delete($id){

        $materi = Materi::find($id);

//        return dirname($materi->file_url);
        try {
            Storage::disk('public')->deleteDirectory(dirname($materi->file_url));
        }catch (RootViolationException $ex){
            
        }

        $materi->delete();
        flash('materi berhasil dihapus', 'success');
        return redirect('admin/materi');
    }
}
