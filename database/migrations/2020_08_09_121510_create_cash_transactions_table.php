<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('transaction_type', array('CR','DR'));
            $table->string('transaction_via')->nullable();
            $table->string('loan_from')->nullable();
            $table->decimal('amount',10, 2)->default(0);
            $table->longText('remarks')->nullable();
            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('project_id')->unsigned()->nullable();


            $table->integer('created_by')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('cash_transactions', function($table) {
            $table->foreign('company_id')->references('id')->on('companies');
        });
        Schema::table('cash_transactions', function($table) {
            $table->foreign('project_id')->references('id')->on('projects');
        });
        Schema::table('cash_transactions', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_transactions');
    }
}
