<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BeritaMentoring extends Model
{
    //
    protected $table = 'berita_mentoring';

    public function getKelompok() {
        return $this->belongsTo('App\Kelompok', 'kelompok_id');
    }

    public function getAgenda() {
        return $this->belongsTo('App\Agenda', 'agenda_id');
    }

    public function getNilaiMentee(){
        // Doesn't use Eloquent ORM, karena akan dijoin dengan tabel Mentee
        // Kalo pake eloquent nanti ketika manggil $nilai_mentee->getMentee
        // Dia membutuhkan cost satu query
        // dan jika dilakukan terus menerus akan meningkatkan proses query di database
        // return $this->hasMany('App\Agenda', 'agenda_id');

        return DB::table('nilai_mentee as nilai')
            ->select('nilai.id', 'nilai.kehadiran', 'nilai.kultum', 'mentee.nim',
                'mentee.nama', 'mentee.kelas')
            ->leftJoin('mentee', 'nilai.mentee_id', 'mentee.id')
            ->where('nilai.berita_mentoring_id', $this->id)
            ->get();

        // return explanation
        // mengembalikan nilai mentee beserta data mentee terkait
        // pada suatu berita acara
    }
}
