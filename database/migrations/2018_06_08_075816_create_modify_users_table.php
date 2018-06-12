<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
             $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('sex',5)->nullable();
            $table->text('bio')->nullable();
            $table->string('phone',10)->nullable();
            $table->string('country_code',4)->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->nullable();
            $table->string('region')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('google')->nullable();
            $table->string('pinterest',10)->nullable();
            $table->string('whatsup',4)->nullable();
            $table->string('instagram')->nullable();
            $table->string('github')->nullable();
             $table->string('avatar')->nullable();
              $table->string('college')->nullable();
            $table->string('high_school')->nullable();
            $table->string('skills')->nullable();
            $table->text('work_experience')->nullable();
            $table->text('awards')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
