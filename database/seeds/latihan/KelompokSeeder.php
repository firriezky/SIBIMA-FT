<?php

use App\Kelompok;
use App\Mentor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelompokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('kelompok')->delete();

        $mentor_1 = Mentor::where('nim','1301140171')->first();
        $asisten_mentor = Mentor::where('nim','1301123301')->first();
        Kelompok::create([
            "mentor_id"=>$mentor_1->id,
            "mentor_asisten_id"=>$asisten_mentor->id
        ]);
    }
}
