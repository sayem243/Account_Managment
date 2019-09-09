<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_details', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->double('demand_amount', 10, 2);
            $table->double('paid_amount',10, 2);

            $table->integer('payment_id')->unsigned()->nullable();


        });


        Schema::table('payment_details', function($table) {
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
        Schema::dropIfExists('payment_details');
    }
}