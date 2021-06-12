<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRekeningAndCredentialForMentor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mentor', function (Blueprint $table) {
            $table->string('no_rekening')->nullable();
            $table->string('path_ktp')->nullable();
            $table->string('path_ktm')->nullable();
            $table->string('path_rekening')->nullable();
            $table->string('is_lanjut')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('berita_mentoring', function (Blueprint $table) {
            $table->dropColumn('no_rekening');
            $table->dropColumn('path_ktp');
            $table->dropColumn('path_ktm');
            $table->dropColumn('path_tabungan');
            $table->dropColumn('is_lanjut');
        });
    }
}
