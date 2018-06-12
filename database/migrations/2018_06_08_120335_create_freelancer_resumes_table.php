<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreelancerResumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freelancer_resumes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('freelancer_id')->unsigend();
            $table->text('bio_info');
            $table->string('education_level');
            $table->text('portfolio_link')->nullable();
            $table->text('references');
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
        Schema::dropIfExists('freelancer_resumes');
    }
}
