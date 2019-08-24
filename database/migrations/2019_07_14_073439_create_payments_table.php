<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->double('d_amount', 10, 2);
            $table->double('due',10, 2);

            $table->integer('company_id')->unsigned()->nullable();

            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('project_id')->unsigned()->nullable();


            $table->smallInteger('status')->default(0);
            $table->dateTime('moderated_at')->nullable();
            $table->string('comments');


            $table->timestamps();
        });


        Schema::table('payments', function($table) {
            $table->foreign('company_id')->references('id')->on('companies');

        });

        Schema::table('payments', function($table) {
            $table->foreign('user_id')->references('id')->on('users');

        });

        Schema::table('payments', function($table) {
            $table->foreign('project_id')->references('id')->on('projects');

        });

//        Schema::table('payments', function($table) {
//            $table->foreign('user_types_id')->references('id')->on('user_types');
//
//        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
