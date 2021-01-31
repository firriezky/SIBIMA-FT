<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    //
    protected $table = 'presensi';

    public function mentee(){
        return $this->belongsTo('App\Mentee', 'mentee_id');
    }

    public function mentor(){
        return $this->belongsTo('App\Mentor', 'mentor_id');
    }

    public function agenda(){
        return $this->belongsTo('App\Agenda', 'agenda_id');
    }

    public function isTelat(){
        // jika telat return true, else return false
        return $this->waktu_hadir > $this->agenda->tanggal_akhir ? true : false;
    }

    public function isTugas(){
        // jika tugas return true, else return false
        return $this->tugas ? true : false;
    }


}
