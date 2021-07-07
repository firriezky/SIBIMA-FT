<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGajiToKelompok extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kelompok', function (Blueprint $table) {
            $table->text('status_gaji')->nullable();
            $table->text('pentransfer')->nullable();
            $table->text('jumlah_gaji')->nullable();
            $table->text('path_transfer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kelompok', function (Blueprint $table) {
            $table->dropColumn('status_gaji');
            $table->dropColumn('pentransfer');
            $table->dropColumn('jumlah_gaji');
            $table->dropColumn('path_transfer');
        });
    }
}
