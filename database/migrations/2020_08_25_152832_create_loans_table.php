<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('payment_mode', array('CASH','CHECK'));
            $table->decimal('amount',10, 2)->default(0);
            $table->enum('loan_from',array('USER','COMPANY','PROJECT','CLIENT','OTHERS'));
            $table->string('loan_from_ref_id');
            $table->integer('check_registry_id_for_loan_from')->unsigned()->nullable();
            $table->integer('cash_transaction_id_for_loan_from')->unsigned()->nullable();
            $table->enum('loan_to',array('USER','COMPANY','PROJECT','CLIENT','OTHERS'));
            $table->string('loan_to_ref_id');
            $table->integer('check_registry_id_for_loan_to')->unsigned()->nullable();
            $table->integer('cash_transaction_id_for_loan_to')->unsigned()->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->timestamps();
        });
        Schema::table('loans', function($table) {
            $table->foreign('check_registry_id_for_loan_from')->references('id')->on('check_registries');
        });
        Schema::table('loans', function($table) {
            $table->foreign('check_registry_id_for_loan_to')->references('id')->on('check_registries');
        });
        Schema::table('loans', function($table) {
            $table->foreign('cash_transaction_id_for_loan_from')->references('id')->on('cash_transactions');
        });
        Schema::table('loans', function($table) {
            $table->foreign('cash_transaction_id_for_loan_to')->references('id')->on('cash_transactions');
        });

        Schema::table('loans', function($table) {
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
