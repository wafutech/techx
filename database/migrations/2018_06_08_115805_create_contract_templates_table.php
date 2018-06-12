<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('work_desc');
            $table->text('project_scope');
            $table->text('kill_fee');
            $table->text('pricing');
            $table->text('freelancer_agreement');
            $table->text('client_agreement');
            $table->text('contact');
            $table->text('conceliation');
            $table->text('copyright');
            $table->text('confidentiality');
            $table->text('indemnification');
            $table->text('review');
            $table->text('additional_info');
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
        Schema::dropIfExists('contract_templates');
    }
}
