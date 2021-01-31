<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMentorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mentor', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nim')->unique();
            $table->string('password');
            $table->string('nama');
            $table->string('fakultas')->index();

            $table->string('no_telp')->nullable();
            $table->string('line_id')->nullable();
            $table->integer('jk'); //1 = ikhwan, 2  = akhwat
            $table->string('foto_url')->nullable();

            $table->boolean('status')->nullable();
            
            // bisa diambil dengan dari NIM (huruf angka ke 5 & 6)
            // method sudah dibuat dengan nama getTahunAngkatan()
            // $table->string('tahun_masuk')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('mentor');
    }
}
