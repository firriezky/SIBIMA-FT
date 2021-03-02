<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

# Command used 
# php artisan make:migration add_photo_to_berita_mentoring --table=berita_mentorings

class AddPhotoToBeritaMentoring extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('berita_mentoring', function (Blueprint $table) {
            $table->string('photo')->nullable();
            $table->string('record_gmeet')->nullable();
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
            $table->dropColumn('photo');
            $table->dropColumn('record_gmeet');
        });
    }
}
