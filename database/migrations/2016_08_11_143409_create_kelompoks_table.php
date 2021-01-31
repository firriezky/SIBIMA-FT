<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKelompoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelompok', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            //ini foreign key untuk id mentor ke tabel mentor
            $table->integer('mentor_id')->unsigned()->nullable();
            $table->foreign('mentor_id')->references('id')->on('mentor')->onDelete('set null');
            // Banyak page yang tidak dicek mentor null, jadi akan error
            // tetapi tidak bakal terjadi kasus kelompok mentor null

            //ini foreign key untuk id asisten mentor ke tabel mentor
            $table->integer('asisten_id')->unsigned()->nullable();
            $table->foreign('asisten_id')->references('id')->on('mentor')->onDelete('set null');

            $table->string('kode')->nullable()->unique();

            // 1 == Ikhwan, 2 == Akhwat
            $table->integer('type')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelompok');
    }
}
