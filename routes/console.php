<?php

use App\Kelompok;
use App\Mentee;
use App\Mentor;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Inspiring;
use App\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('admin:list', function(){
    $admins = Admin::all();
    foreach ($admins as $admin){
        $this->comment("- " . $admin->username);
    }
});

Artisan::command('admin:make {username} {password}', function($username, $password){

    try {
        Admin::create([
            "username" => $username,
            "password" => Hash::make($password)
        ]);
        $this->comment("Super Admin SIBIMA succesfully created");

    }catch (QueryException $qe){
        $this->comment("Error : Super Admin Username Duplicate");

    }

});

Artisan::command('admin:change {username} {new_password}', function($username, $new_password){
    $admin = Admin::where('username', $username)->first();
    if ($admin != null){
        $admin->password = Hash::make($new_password);
        $admin->save();
        $this->comment("Super Admin SIBIMA '" . $username . "' password has been change");
    } else {
        $this->comment("Super Admin SIBIMA not found");
    }

});

Artisan::command('admin:delete {username}', function($username){
    $admin = Admin::where('username', $username)->first();
    if ($admin != null){
        $admin->delete();
        $this->comment("Super Admin SIBIMA '" . $username . "' has successfully deleted");
    } else {
        $this->comment("Super Admin SIBIMA not found");
    }
});

Artisan::command('kelompok:generate {id}', function($id){

    if ($id != 1 && $id != 2) {
        $this->comment("Error : Type ID 1 (Ikhwan) / 2 (Akhwat)");

    } else {

        try {

            $all_mentee = Mentee::where('jk', $id)->get();
            $all_mentor = Mentor::where('jk', $id)->get();
    
            if (count($all_mentee) != 0 && count($all_mentor) != 0){
                
                $count_mentee = 0;
                foreach ($all_mentor as $mentor){
        
                    $kelompok = new Kelompok();
                    $kelompok->mentor_id = $mentor->id;
        
                    if ($id == 1){
                        $id_kelompok = DB::table('kelompok_it')->insertGetId([]);
                        $kelompok->kode = "IT-" . $id_kelompok;
                        $kelompok->type = 1;
        
                    } else {
                        $id_kelompok = DB::table('kelompok_at')->insertGetId([]);
                        $kelompok->kode = "AT-" . $id_kelompok;
                        $kelompok->type = 2;
        
                    }
        
                    $kelompok->save();
        
                    for($i=0; $i<10; $i++){
        
                        $all_mentee[$count_mentee]->kelompok_id = $kelompok->id;
                        $all_mentee[$count_mentee]->save();
                        $count_mentee++;
        
                    }
        
                }

                $this->comment("Kelompok has been successfully generated");

            } else {
                $this->comment("Warning : Database nulled, please seed the db first or export data");

            }

        } catch (QueryException $qe){
            $this->comment("Error : Please migrate database first");

        } catch (ErrorException $ex) {
            $this->comment("Generate Success");
            $this->comment("Warning : Not All Mentor has been assigned to kelompok");
        }

    }


});
