<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_title');
            $table->string('short_desc');
            $table->text('detail_desc');
            $table->integer('product_category_id')->unsigned();
            $table->float('price');
            $table->boolean('sponsored')->default(false);
            $table->string('vendor');
            $table->string('developer_website')->nullable();
            $table->string('product_image');
            $table->string('demo_video')->nullable();
            $table->string('product_file');
            $table->string('currency');
            $table->string('download_file_size');
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
        Schema::dropIfExists('store_products');
    }
}
