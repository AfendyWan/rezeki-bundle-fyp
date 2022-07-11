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
            $table->string('itemName')->nullable();
            $table->bigInteger('itemCategory')->unsigned()->nullable();
            $table->integer('itemStock')->nullable();
            $table->string('itemColor')->nullable();
            $table->string('itemSize')->nullable();
            $table->string('itemBrand')->nullable();
            $table->decimal('itemPrice',12,2)->nullable();
            $table->boolean('itemPromotionStatus')->nullable();
            $table->decimal('itemPromotionPrice',7,2)->nullable();
            $table->date('itemPromotionStartDate')->nullable();
            $table->date('itemPromotionEndDate')->nullable();
            $table->boolean('itemActivationStatus')->nullable();
            $table->text('itemDescription')->nullable();

            $table->timestamps();

            $table->foreign('itemCategory')->references('id')->on('sale_item_categories')->onUpdate('cascade')->onDelete('cascade');
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
