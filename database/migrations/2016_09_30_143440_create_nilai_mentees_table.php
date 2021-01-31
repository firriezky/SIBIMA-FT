<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNilaiMenteesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_mentee', function (Blueprint $table) {
            $table->increments('id');

            // Reference to table Mentee
            $table->integer('mentee_id')->unsigned();
            $table->foreign('mentee_id')->references('id')->on('mentee')->onDelete('cascade');

            // Reference to table Berita Acara
            $table->integer('berita_mentoring_id')->unsigned();
            $table->foreign('berita_mentoring_id')->references('id')->on('berita_mentoring')->onDelete('cascade');

            // data materi kultum disimpan di berita mentoring saja fixnya
            //$table->string('materi_kultum')->nullable();

            $table->integer('kultum')->nullable(); // 1 - 100
            $table->integer('kehadiran')->nullable(); // 1 - 100
            
            // ini lupa lagi dulu buat apa wkwkw
            //$table->integer('nilai_status')->nullable(); // 1 - 100

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
        Schema::dropIfExists('nilai_mentee');
    }
}
