<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('expected_duration_id')->unsigned();
            $table->integer('complexity_id')->unsigned();
            $table->text('job_desc');
            $table->integer('main_skill_id')->unsigned();
            $table->integer('payment_type_id')->unsigned();
             $table->integer('job_category_id')->unsigned();
            $table->decimal('payment_amount');
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
        Schema::dropIfExists('jobs');
    }
}
