<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVocherDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vocher_details', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('amount',10, 2);

            $table->integer('vocher_id')->unsigned()->nullable();
            $table->integer('payment_id')->unsigned()->nullable();
            $table->integer('project_id')->unsigned()->nullable();
            $table->integer('payment_details_id')->unsigned()->nullable();
            $table->string('filenames')->nullable();
            $table->timestamps();
        });

        Schema::table('vocher_details', function($table) {
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');

        });

        Schema::table('vocher_details', function($table) {
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');

        });

        Schema::table('vocher_details', function($table) {
            $table->foreign('vocher_id')->references('id')->on('vochers')->onDelete('cascade');

        });

        /*Schema::table('vocher_details', function($table) {
            $table->foreign('payment_details_id')->references('id')->on('payment_details');
        });*/


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vocher_details');
    }
}
