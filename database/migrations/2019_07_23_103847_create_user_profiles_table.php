<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fname');
            $table->string('lname');
            $table->string('email');
      ;
            $table->string('mothername');
            $table->string('fathername');

            $table->string('p_address');
            $table->string('address');


            $table->string('joindate');
            $table->string('nid');
            $table->string('mobile');


            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();



            $table->timestamps();
        });

        Schema::table('user_profiles', function($table) {
            $table->foreign('company_id')->references('id')->on('companies');


        });



        Schema::table('user_profiles', function($table) {
            $table->foreign('user_id')->references('id')->on('users');

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
}
