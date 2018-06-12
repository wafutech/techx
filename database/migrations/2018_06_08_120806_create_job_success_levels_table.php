<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobSuccessLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_success_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('freelancer_id')->unsigned();
            $table->integer('job_id')->unsigned();
            $table->decimal('success_level');
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
        Schema::dropIfExists('job_success_levels');
    }
}
