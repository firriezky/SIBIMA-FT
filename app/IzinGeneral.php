<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IzinGeneral extends Model
{
    //
    protected $table = "izin_general";

    public function getMentee(){
        return $this->belongsTo('App\Mentee', 'mentee_id');
    }

    public function getAgenda(){
        return $this->belongsTo('App\Agenda', 'agenda_id');
    }

    public function getKategori(){
        if($this->kategori == 1)
            return "Sakit";
        elseif ($this->kategori == 2)
            return "Urusan Keluarga";
        elseif ($this->kategori == 3)
            return "Kegiatan Akademik";
        elseif ($this->kategori == 4)
            return "Berita Duka";
        else
            return "UNCATEGORIZED";
    }

    public function getStatus(){
        // 0 = Belum diproses
        // 1 = Accepted
        // 2 = Rejected

        if ($this->status == 0){
            return "Belum diproses";
        } elseif ($this->status == 1) {
            return "Accepted";
        } elseif ($this->status == 2) {
            return "Rejected";
        } else {
            return "UNKNOWN";
        }
    }
}
