<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('totalPrice',12,2)->nullable();
            $table->decimal('subTotalPrice',12,2)->nullable();                   
            $table->decimal('shippingPrice',12,2)->nullable();       
            $table->integer('paymentStatus')->nullable();
            $table->string('remark')->nullable();
            $table->bigInteger('cart_id')->unsigned()->nullable();           
            $table->bigInteger('userID')->unsigned()->nullable();
            $table->bigInteger('order_id')->unsigned()->nullable();
           
            $table->dateTime('paymentDate')->nullable();
            
            $table->foreign('cart_id')->references('id')->on('carts')->onUpdate('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onUpdate('cascade');
            $table->foreign('userID')->references('id')->on('users')->onUpdate('cascade');
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
        Schema::dropIfExists('payments');
    }
}
