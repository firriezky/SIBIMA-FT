<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeritaMentoringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berita_mentoring', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('kelompok_id')->unsigned();
            $table->foreign('kelompok_id')->references('id')->on('kelompok')->onDelete('cascade');

            $table->string('materi_kultum')->nullable();
            $table->string('tempat')->nullable();
            $table->dateTime('tanggal')->nullable();
            $table->string('materi')->nullable();

            $table->integer('agenda_id')->unsigned();
            $table->foreign('agenda_id')->references('id')->on('agenda')->onDelete('cascade');

            $table->boolean('telat_input')->nullable()->default(false);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('berita_mentoring');
    }
}
