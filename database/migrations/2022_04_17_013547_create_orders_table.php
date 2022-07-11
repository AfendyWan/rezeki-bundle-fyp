<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->dateTime('orderDate')->nullable();
            $table->string('order_number', 20)->nullable();
            $table->bigInteger('userID')->unsigned()->nullable();
            $table->bigInteger('paymentID')->unsigned()->nullable();
            $table->bigInteger('shipmentID')->unsigned()->nullable();
            $table->string('orderStatus', 255)->nullable();
            
            $table->foreign('userID')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('paymentID')->references('id')->on('payments')->onUpdate('cascade');
            $table->foreign('shipmentID')->references('id')->on('shipments')->onUpdate('cascade');
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
        Schema::dropIfExists('orders');
    }
}
