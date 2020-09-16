<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_details', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('bill_amount',10, 2)->default(0);
            $table->decimal('certifite_amount',10, 2)->default(0);
            $table->decimal('sd_amount',10, 2)->default(0);
            $table->decimal('it_amount',10, 2)->default(0);
            $table->decimal('vat_amount',10, 2)->default(0);
            $table->decimal('others_amount',10, 2)->default(0);
            $table->decimal('check_amount',10, 2)->default(0);
            $table->string('check_referance')->nullable();
            $table->string('bill_invoice_number')->nullable();
            $table->integer('income_id')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('income_details', function($table) {
            $table->foreign('income_id')->references('id')->on('incomes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('income_details');
    }
}
