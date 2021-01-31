<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TugasBesar extends Model
{
    //
    protected $table = 'tugas_besar';
    protected $primaryKey = 'kelompok_id';

    public function getKelompok(){
        return $this->belongsTo('App\Kelompok', 'kelompok_id');
    }
}
