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

            $table->string('additional_amount');

            $table->integer('payment_id')->unsigned()->nullable();
            $table->string('approved');



            $table->timestamps();
        });

        Schema::table('ammendments', function($table) {
            $table->foreign('payment_id')->references('id')->on('payments');

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
