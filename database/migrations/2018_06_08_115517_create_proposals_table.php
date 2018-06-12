<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id')->unsigned();
            $table->integer('freelancer_id')->unsigned();
             $table->integer('payment_type_id')->unsigned();
             $table->text('cover_letter');
             $table->decimal('payment_amount');
             $table->integer('current_proposal_status_id')->unsigned();
             $table->integer('client_grade')->unsigned()->nullable();
             $table->integer('freelancer_grade')->unsigned()->nullable();
             $table->text('client_comment')->nullable();
               $table->text('freelancer_comment')->nullable();
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
        Schema::dropIfExists('proposals');
    }
}
