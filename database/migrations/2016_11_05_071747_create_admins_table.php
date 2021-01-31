<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // check if table admin exist (disable table admin migration)
        if (! Schema::hasTable('admin')) {
            
            Schema::create('admin', function (Blueprint $table) {
                $table->increments('id');

                $table->string('username')->unique();
                $table->string('password');

                $table->rememberToken();
                $table->timestamps();
            });
            
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Disable remigrate admin table
//        Schema::dropIfExists('admin');
    }
}
