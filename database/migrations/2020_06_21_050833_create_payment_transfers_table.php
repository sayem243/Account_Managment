<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('transfer_amount',10, 2)->default(0);

            $table->integer('payment_id')->unsigned()->nullable();

            $table->integer('reference_payment_id')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('payment_transfers', function($table) {
            $table->foreign('payment_id')->references('id')->on('payments');

        });

        Schema::table('payment_transfers', function($table) {
            $table->foreign('reference_payment_id')->references('id')->on('payments');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_transfers');
    }
}
