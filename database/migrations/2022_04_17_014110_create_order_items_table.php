<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
           
            $table->integer('quantity')->nullable();
            $table->decimal('orderPrice',12,2)->nullable(); 
            $table->bigInteger('order_id')->unsigned()->nullable();
            $table->bigInteger('sale_item_id')->unsigned()->nullable();
            $table->integer('feedback_status')->nullable();   

            $table->foreign('order_id')->references('id')->on('orders')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('sale_item_id')->references('id')->on('sale_items')->onUpdate('cascade');
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
        Schema::dropIfExists('order_items');
    }
}
