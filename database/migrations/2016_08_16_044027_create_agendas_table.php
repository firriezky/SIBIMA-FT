<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('judul');
            $table->integer('tipe'); // 1 = mentoring, 2 = general, 3 = talaqi, 4 = tugas besar
            $table->dateTime('tanggal_akhir');

            // for general & talaqi only
            $table->string('materi')->nullable();
            $table->string('tempat')->nullable();

            // for talaqi only
            $table->string('fakultas')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agenda');
    }
}
