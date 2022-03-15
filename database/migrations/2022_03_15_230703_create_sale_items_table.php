<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->string('itemName')->unique();
            $table->string('itemCategory')->unique();
            $table->integer('itemStock')->nullable();
            $table->decimal('itemPrice',7,2)->nullable();
            $table->boolean('itemPromotionStatus')->nullable();
            $table->decimal('itemPromotionPrice',7,2)->nullable();
            $table->boolean('itemActivationStatus')->nullable();
            $table->text('itemDescription')->nullable();

            $table->timestamps();

            $table->foreign('itemCategory')->references('name')->on('sale_item_categories')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_items');
    }
}
