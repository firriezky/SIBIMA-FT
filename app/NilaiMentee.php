<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NilaiMentee extends Model
{
    //
    protected $table = 'nilai_mentee';


    public function getMentee()
    {
        return $this->belongsTo('App\Mentee', 'mentee_id');
    }

    public function getBeritaMentoring()
    {
        return $this->belongsTo('App\BeritaMentoring', 'berita_mentoring_id');
    }

}
