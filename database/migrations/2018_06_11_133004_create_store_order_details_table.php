<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unisigned();
            $table->integer('product_id')->unisigned();
            $table->float('amount');
            $table->float('unit_price');
           $table->integer('qty')->default(1);
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
        Schema::dropIfExists('store_ordet_details');
    }
}
