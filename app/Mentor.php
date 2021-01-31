<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class Mentor extends Authenticatable
{
    use Notifiable;

    protected $table = 'mentor';

    protected $fillable = [
        'nama', 'nim', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJK(){
        return $this->jk == 1 ? "Ikhwan" : "Akhwat";
    }

    public function getKelompok() {
        return $this->hasMany('App\Kelompok', 'mentor_id');
    }

    public function getKelompokAsisten() {
        // Dia mereturn kelompok yang mentor tersebut asisteni
        return $this->hasMany('App\Kelompok', 'asisten_id');
    }

    public function getPresensiTalaqi($agenda_id){
        return Presensi::where('agenda_id', $agenda_id)
            ->where('mentor_id', $this->id)->first();

            // return object presensi dengan agenda X apabila mentee hadir mentoring general
            // jika mentee tidak hadir, maka return null
    }

    public function getPresensiTalaqiSeries(){
        $agendas = Agenda::where('tipe', 3)
            ->where('fakultas', $this->fakultas)->get();

        $presensi_series = [];
        foreach ($agendas as $agenda){
            $presensi = $this->getPresensiTalaqi($agenda->id);
            array_push($presensi_series, [
                "agenda" => $agenda,
                "presensi" => $presensi
            ]);
        }

        return $presensi_series;

        // Return Sample
//        => [
//            [ "agenda" => OBJECT_AGENDA,
//              "presensi" => null, // Kalo tidak hadir ],
//            [ "agenda" => OBJECT_AGENDA,
//              "presensi" => "OBJECT_PRESENSI" // kalo hadir, panggil method isTelat() untuk cek telat, note],
//        ]
    }
    
    // Mengambil data total sudah berapa kali jadi mentor (INT)
    public function getTotalKelompok() {
        $total = DB::table('kelompok')
            ->where('mentor_id', $this->id)
            ->count();
        return $total;
    }

    // Mengambil data total sudah berapa kali jadi asisten (INT)
    public function getTotalAsisten() {
        $total = DB::table('kelompok')
            ->where('asisten_id', $this->id)
            ->count();
        return $total;
    }

    public static function allMentorCounterMentor($jk){
        // Raw Query
        //SELECT mentor.id, mentor.nama, mentor.fakultas, count(kelompok.id) FROM mentor
        // LEFT JOIN kelompok ON mentor.id = kelompok.mentor_id WHERE jk = 1 GROUP by mentor.id

        return DB::table('mentor')
            ->select('mentor.id', 'mentor.nama', 'mentor.fakultas', DB::raw('count(kelompok.id) as total'))
            ->leftJoin('kelompok', 'mentor.id', 'kelompok.mentor_id')
            ->where('mentor.jk', $jk)
            ->groupBy('mentor.id', 'mentor.nama', 'mentor.fakultas')
            ->get();
    }

    public static function allMentorCounterAsisten($jk){
        // Raw Query
        //SELECT mentor.id, mentor.nama, mentor.fakultas, count(kelompok.id) FROM mentor
        // LEFT JOIN kelompok ON mentor.id = kelompok.mentor_id WHERE jk = 1 GROUP by mentor.id

        return DB::table('mentor')
            ->select('mentor.id', 'mentor.nama', 'mentor.fakultas', DB::raw('count(kelompok.id) as total'))
            ->leftJoin('kelompok', 'mentor.id', 'kelompok.asisten_id')
            ->where('mentor.jk', $jk)
            ->groupBy('mentor.id', 'mentor.nama', 'mentor.fakultas')
            ->get();
    }

    public function getTahunMasuk(){
        return "20" . substr($this->nim, 4,2);
    }

}

