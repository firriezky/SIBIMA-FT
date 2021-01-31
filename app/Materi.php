<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    //
    protected $table = 'materi';

    public function getTipe(){
        return $this->tipe == 1 ? "Mentor" : "Mentee";
    }
}
