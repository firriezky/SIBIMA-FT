<?php
/**
 * Created by PhpStorm.
 * User: Bismillah
 * Date: 30/12/2016
 * Time: 21.20
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    public function input(){
        return view('admin.pengumuman.input');
    }

    public function viewPenggumuman(){
    	$list_pengumuman = Pengumuman::paginate(10);
        return view('admin.pengumuman.manage', ["list_pengumuman" => $list_pengumuman]);
    }

    public function submit(Request $request){
    	$judul = $request->input('judul');
    	$detail = $request->input('detail');
    	$file = $request->file('dokumen');

    	$pengumuman = new Pengumuman();
    	$pengumuman->judul = $judul;
    	$pengumuman->detail = $detail;
    	$pengumuman->file_url = "";
		$pengumuman->tipe = $request->input('tipe');

		$pengumuman->save();

    	if($file != null){
    		$path = $file->storeAs('storage/pengumuman/'.$pengumuman->id, $file->getClientOriginalName(), 'public');
	    	$pengumuman->file_url = $path;
    		$pengumuman->save();

    	}

    	flash('Pengumuman berhasil di upload', 'success');
    	return redirect('admin/pengumuman');
    }

	public function delete($id){
		Pengumuman::destroy($id);
		flash("Pengumuman berhasil dihapus", "success");
		return redirect("admin/pengumuman");
	}

	public function detail($id){
		$pengumuman = Pengumuman::find($id);
		if($pengumuman != null){

			return view('admin.pengumuman.detail', [
				"pengumuman" => $pengumuman
			]);

		} else {
			flash("Pengumuman Not Found", "danger");
			return redirect("admin/pengumuman");

		}
	}
}