<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHireManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hire_managers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
             $table->string('company')->nullable();
            $table->text('company_desc')->nullable();
            $table->integer('company_contry_id')->unsigned();
            $table->string('company_city');
            $table->string('number_of_employees')->nullable();
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
        Schema::dropIfExists('hire_managers');
    }
}
