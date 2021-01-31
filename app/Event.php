<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model {
    
    public function isEnded(){
        return Carbon::now() > $this->start;

        // keterangan
        // return true jika event lewat
        // return false jika event belum lewat
        // note : waktu server harus sesuai dengan timezone asia/jakarta
    }

}
