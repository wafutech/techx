<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
             $table->integer('proposal_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->integer('freelancer_id')->unsigned();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('payment_type_id')->unsigned();
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
        Schema::dropIfExists('contracts');
    }
}
