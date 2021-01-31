<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presensi', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            // Reference to table Mentee (buat presensi general)
            $table->integer('mentee_id')->unsigned()->nullable();
            $table->foreign('mentee_id')->references('id')->on('mentee')->onDelete('cascade');

            // Reference to table mentor (buat presensi talaqi)
            $table->integer('mentor_id')->unsigned()->nullable();
            $table->foreign('mentor_id')->references('id')->on('mentor')->onDelete('cascade');

            // Reference to table Agenda
            $table->integer('agenda_id')->unsigned();
            $table->foreign('agenda_id')->references('id')->on('agenda')->onDelete('cascade');

            // Tanggal Hadir - Carbon::now()
            $table->dateTime('waktu_hadir');

            // Apakah presensi diganti tugas ?? nilai == 60
            $table->boolean('tugas')
                ->default(false)
                ->nullable();

            // Field Field Telat // diganti dengan method isTelat() pada model Presensi
            //$table->boolean('telat')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presensi');
    }
}
