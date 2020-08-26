<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('payment_mode', array('CASH','CHECK'));
            $table->decimal('amount',10, 2)->default(0);
            $table->enum('income_from',array('USER','COMPANY','PROJECT','CLIENT','OTHERS'));
            $table->string('income_from_ref_id');
            $table->integer('check_registry_id')->unsigned()->nullable();
            $table->integer('cash_transaction_id')->unsigned()->nullable();
            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('project_id')->unsigned()->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('incomes', function($table) {
            $table->foreign('cash_transaction_id')->references('id')->on('cash_transactions');
        });
        Schema::table('incomes', function($table) {
            $table->foreign('check_registry_id')->references('id')->on('check_registries');
        });

        Schema::table('incomes', function($table) {
            $table->foreign('company_id')->references('id')->on('companies');
        });
        Schema::table('incomes', function($table) {
            $table->foreign('project_id')->references('id')->on('projects');
        });

        Schema::table('incomes', function($table) {
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
        Schema::dropIfExists('incomes');
    }
}
