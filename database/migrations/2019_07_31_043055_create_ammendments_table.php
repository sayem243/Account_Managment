<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmmendmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ammendments', function (Blueprint $table) {
            $table->increments('id');

            $table->decimal('amendment_amount',10, 2);
            $table->string('file')->nullable();

            $table->integer('payment_id')->unsigned()->nullable();

            $table->integer('project_id')->unsigned()->nullable();
            $table->string('approved');

            $table->timestamps();
        });

        Schema::table('ammendments', function($table) {
            $table->foreign('payment_id')->references('id')->on('payments');

        });

        Schema::table('ammendments', function($table) {
            $table->foreign('project_id')->references('id')->on('projects');

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ammendments');
    }
}
