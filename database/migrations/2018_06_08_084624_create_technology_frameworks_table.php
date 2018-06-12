<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTechnologyFrameworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technology_frameworks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('framework');
            $table->string('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('url')->nullable();
            $table->integer('technology_id')->unsigned();
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
        Schema::dropIfExists('technology_frameworks');
    }
}
