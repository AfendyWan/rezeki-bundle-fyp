<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();

            $table->string('shippingAddress')->nullable();
            $table->string('shippingOption')->nullable();
            $table->string('shippingLocalDateTime')->nullable();
            $table->string('shippingStatus')->nullable();
            $table->string('shippingCourier')->nullable();
            $table->string('shippingTrackingNumber')->nullable();

            $table->bigInteger('cart_id')->unsigned()->nullable();
            $table->foreign('cart_id')->references('id')->on('carts')->onUpdate('cascade');
            $table->bigInteger('payment_id')->unsigned()->nullable();
            $table->foreign('payment_id')->references('id')->on('payments')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('userID')->unsigned()->nullable();
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
        Schema::dropIfExists('shipments');
    }
}
