<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    //
    protected $table = 'agenda';

    public function isEnded(){
        return Carbon::now() > $this->tanggal_akhir;

        // keterangan
        // return true jika agenda berakhir
        // return false jika agenda belum berakhir
        // note : waktu server harus sesuai dengan timezone asia/jakarta
    }

    public function getTipe(){
        if($this->tipe == 1) {
            return "Mentoring";
        } else if($this->tipe == 2) {
            return "General";
        } else if($this->tipe == 3) {
            return "Talaqi";
        } else if($this->tipe == 4) {
            return "Tugas Besar";
        }

    }

    // Mengecek apakah berita mentoring kelompok X terdapat pada Agenda Y;
    // Method Accepted
    public function isKelompokBeritaExist($kelompok_id){
        $berita = BeritaMentoring::where('agenda_id', $this->id)
            ->where('kelompok_id', $kelompok_id)
            ->first();

        if ($berita == null) {
            return false;
        } else {
            return true;
        }
    }

    // Mengecek apakah Mentor sudah menginput berita acara pada Agenda X
    // Accepted
    public function isAlreadyInput($mentor_id){

        // Terdapat loop untuk mengecek kondisi Mentor punya lebih dari 1 kelompok
        $kelompoks = Kelompok::where('mentor_id', $mentor_id)->get();
        foreach ($kelompoks as $kelompok){
            if (!$this->isKelompokBeritaExist($kelompok->id)){
                return false;
            }
        }

        return true;

        // Note: RETURN TRUE JIKA MENTOR TIDAK PUNYA KELOMPOK SATUPUN 11
    }

    // Mengecek Apakah Mentee X, sudah mengajukan izin pada agenda general terkait
    public function isMenteeProposeIzinGeneral($mentee_id){

        if ($this->tipe != 2){
            return false;
        } else {

            $izin = IzinGeneral::where('agenda_id', $this->id)
                ->where('mentee_id', $mentee_id)
                ->first();

            // return true, jika mentee sudah izin
            // false, jika mentee belum izin
            return $izin != null ? true : false;
        }

    }
}
