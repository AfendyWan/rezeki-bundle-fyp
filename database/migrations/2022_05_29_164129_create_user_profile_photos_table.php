<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profile_photos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userID')->unsigned()->nullable();
         
            $table->string('url');
            $table->foreign('userID')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('user_profile_photos');
    }
}
