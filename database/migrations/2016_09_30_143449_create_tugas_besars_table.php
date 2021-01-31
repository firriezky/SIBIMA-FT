<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTugasBesarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tugas_besar', function (Blueprint $table) {

            // kelompok_id Foreign Key to Table Kelompok
            $table->integer('kelompok_id')->unsigned();
            $table->primary('kelompok_id');
            $table->foreign('kelompok_id')->references('id')->on('kelompok')->onDelete('cascade');

            $table->string('judul');
            $table->integer('nilai')->nullable(); // 1 - 100
            $table->string('video_link');
            $table->string('deskripsi');
            $table->string('fakultas');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tugas_besar');
    }
}
