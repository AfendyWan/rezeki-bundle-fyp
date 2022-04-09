<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishListItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wishList_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
           
            $table->bigInteger('wish_id')->unsigned()->nullable();
            $table->bigInteger('sale_item_id')->unsigned()->nullable();
         
            $table->foreign('wish_id')->references('id')->on('wishLists')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('sale_item_id')->references('id')->on('sale_items')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wishList_items');
    }
}
