<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentSettlements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_settlements', function (Blueprint $table) {
            $table->increments('id');

            $table->decimal('settlement_amount',10, 2);
            $table->integer('payment_id')->unsigned()->nullable();
            $table->integer('project_id')->unsigned()->nullable();
            $table->smallInteger('status')->default(1);

            $table->timestamps();
        });

        Schema::table('payment_settlements', function($table) {
            $table->foreign('payment_id')->references('id')->on('payments');

        });

        Schema::table('payment_settlements', function($table) {
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
        Schema::dropIfExists('payment_settlements');
    }
}
