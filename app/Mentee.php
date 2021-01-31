<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class Mentee extends Authenticatable
{
    use Notifiable;

    protected $table = "mentee";
    protected $fillable = [ 'nama', 'nim', 'password' ];
    protected $hidden = [ 'password', 'remember_token', ];

    // Eloquent Relationship
    public function getNilai() {
        return $this->hasMany('App\NilaiMentee', 'mentee_id');
    }

    // Eloquent Relationship
    public function getKelompok(){
        return $this->belongsTo('App\Kelompok', 'kelompok_id');
    }

    // Eloquent Relationship
    public function getIzinGeneral() {
        return $this->hasMany('App\IzinGeneral', 'mentee_id');
    }

    // Method Accepted
    public function getJK(){
        return $this->jk == 1 ? "Ikhwan" : "Akhwat";
    }

    // Accepted
    public function getPresensi($agenda_id){
        return Presensi::where('agenda_id', $agenda_id)
            ->where('mentee_id', $this->id)->first();

        // return object presensi dengan agenda X apabila mentee hadir mentoring general
        // jika mentee tidak hadir, maka return null
    }

    // TODO : Fragile Method - Fix This
    public function getPresensiGeneral(){

        $agendas = Agenda::where('tipe', 2)
            ->where('fakultas', $this->fakultas)
            ->get();

        $presensi_series = [];
        foreach ($agendas as $agenda) {
            $nilai = [];
            $presensi = $this->getPresensi($agenda->id);
            if ($presensi == null) {
                $nilai['agenda'] = $agenda->judul;
                $nilai['nilai'] = 0;
            } else if ($presensi->tugas == true) {
                $nilai['agenda'] = $agenda->judul;
                $nilai['nilai'] = 65;
            // datang telat
            } else if ($presensi->isTelat()){
                $nilai['agenda'] = $agenda->judul;
                $nilai['nilai'] = 85;
            // tidak terlambat dan tidak tugas
            } else {
                $nilai['agenda'] = $agenda->judul;
                $nilai['nilai'] = 100;
            }

            array_push($presensi_series, $nilai);
        }

        return $presensi_series;
        // return sample
        // [
        //   [ "agenda => "Opening 1", "nilai" => 100 ], // jika hadir
        //   [ "agenda => "General II", "nilai" => 80 ], // jika telat / tugas
        //   [ "agenda => "Closing", "nilai" => 0 ], // jika tidak hadir
        // ]
    }

    // TODO : Refactor Response
    public function getNilaiMentoringSeries(){

        // Query using DB:Builder
//        $nilai_series = DB::table('agenda')
//            ->select('agenda.judul', 'nilai.kehadiran', 'nilai.kultum')
////            ->select('agenda.judul', 'bm.id as bm_id')
//            ->leftJoin('berita_mentoring as bm', 'agenda.id', 'bm.agenda_id')
//            ->leftJoin('nilai_mentee as nilai', 'bm.id', 'nilai.berita_mentoring_id')
//            ->where('agenda.tipe', '=', 1)
//            ->orWhereRaw('(nilai.mentee_id = ? or bm.id = ?)', [$this->id, null])
//            ->get();

        $nilai_series = Agenda::where('tipe', 1)->pluck('judul')->toArray();
        $nilai_series = array_flip($nilai_series);

        foreach ($this->getNilai as $nilai){

            // get judul
            $judul = DB::table('nilai_mentee as nilai')
                ->select('agenda.judul')
                ->leftJoin('berita_mentoring as bm', 'nilai.berita_mentoring_id', 'bm.id')
                ->leftJoin('agenda', 'bm.agenda_id', 'agenda.id')
                ->where('nilai.id', $nilai->id)
                ->first();

            $nilai_series[$judul->judul] = [
                "nilai" => $nilai->kehadiran,
                "kultum" => $nilai->kultum
            ];
        }

        // Current Response
//        [
//            "Mentoring 1" => [
//                "nilai" => 123,
//                "kultum" => 0,
//            ],
//            "Mentoring 2" => 2,
//            "Mentoring 3" => 3
//        ]

        return $nilai_series;

    }

    public function getNilaiMentoringByAgenda($id){
        return DB::table('nilai_mentee as nilai')
            ->select('nilai.id', 'nilai.kehadiran', 'nilai.kultum', 
                'mentee.nama', 'mentee.nim', 'mentee.kelas')
            ->leftJoin('berita_mentoring as bm', 'nilai.berita_mentoring_id', 'bm.id')
            ->leftJoin('agenda', 'bm.agenda_id', 'agenda.id')
            ->leftJoin('mentee', 'nilai.mentee_id', 'mentee.id')
            ->where('nilai.mentee_id', $this->id)
            ->where('agenda.id', $id)
            ->first();
    }

    public function getTahunMasuk(){
        return "20" . substr($this->nim, 4,2);
    }
}