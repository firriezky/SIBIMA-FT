<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenteesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mentee', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('nim')->unique();
            $table->string('password');

            $table->integer('jk')->nullable(); //1 = ikhwan, 2  = akhwat
            $table->string('no_telp')->nullable();

            $table->string('fakultas')->nullable()->index();
            $table->string('program_studi')->nullable()->index();
            $table->string('kelas')->nullable();

            $table->string('line_id')->nullable();
    
            $table->integer('kelompok_id')->unsigned()->nullable();
            $table->foreign('kelompok_id')->references('id')->on('kelompok')->onDelete('set null');

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
        Schema::drop('mentee');
    }
}
