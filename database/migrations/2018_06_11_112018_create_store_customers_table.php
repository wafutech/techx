<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('customer_name')->nullable();
             $table->integer('user_id')->unsigned()->nullable();
             $table->string('ip_address')->nullable();
              $table->string('country');
             $table->string('phone');
             $table->string('email');
                 $table->string('shipping_address')->nullable();
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
        Schema::dropIfExists('store_customers');
    }
}
