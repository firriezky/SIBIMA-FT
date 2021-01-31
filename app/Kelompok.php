<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kelompok extends Model
{
    //
    protected $table = 'kelompok';

    // Tested Oke by Kinto-D
    public function getMentor(){
        return $this->belongsTo('App\Mentor', 'mentor_id');
    }

    // Tested
    public function getMentee(){
    	return $this->hasMany('App\Mentee', 'kelompok_id');
    }

    // Tested Oke by Kinto-D
    public function getAsisten(){
        return $this->belongsTo('App\Mentor', 'asisten_id');
    }

    // One to One Relation // Tested
    public function getTugasBesar(){
        return $this->hasOne('App\TugasBesar', 'kelompok_id');
    }

    // Method untuk mengecek apakah kelompok sudah submit tugas besar?
    public function isAlreadySubmitTugasBesar(){
        return $this->getTugasBesar == null ? false : true;
    }

    public function getBeritaMentoring($agenda_id){
        return BeritaMentoring::where('kelompok_id', $this->id)
            ->where('agenda_id', $agenda_id)
            ->first();
    }

}
