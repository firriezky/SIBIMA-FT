<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';

    public function getTipe(){
        return $this->tipe == 1 ? "Mentor" : "Mentee";
    }
}
