<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreelancingStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freelancing_stats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('freelancer_id')->unsigned();
             $table->integer('hire_manager_id')->unsigned();
              $table->integer('job_id')->unsigned();
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
        Schema::dropIfExists('freelancing_stats');
    }
}
