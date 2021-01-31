<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIzinGeneralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('izin_general', function (Blueprint $table) {
            $table->increments('id');

            // Reference to table Mentee
            $table->integer('mentee_id')->unsigned()->nullable();
            $table->foreign('mentee_id')->references('id')->on('mentee')->onDelete('cascade');

            // Reference to table Agenda
            $table->integer('agenda_id')->unsigned();
            $table->foreign('agenda_id')->references('id')->on('agenda')->onDelete('cascade');

            // See Model IzinGeneral->getKategori() for detail;
            $table->integer('kategori');

            $table->string('detail');
            $table->string('surat_url');
            
            // 0 = Belum diproses
            // 1 = Accepted
            // 2 = Rejected
            $table->boolean('status')->default(0);

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
        Schema::dropIfExists('izin_general');
    }
}
