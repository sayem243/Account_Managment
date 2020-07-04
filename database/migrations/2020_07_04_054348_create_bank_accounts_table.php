<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_type')->nullable();
            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('bank_id')->unsigned()->nullable();
            $table->integer('branch_id')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('bank_accounts', function($table) {
            $table->foreign('company_id')->references('id')->on('companies');
        });
        Schema::table('bank_accounts', function($table) {
            $table->foreign('bank_id')->references('id')->on('bank_and_branches');
        });
        Schema::table('bank_accounts', function($table) {
            $table->foreign('branch_id')->references('id')->on('bank_and_branches');
        });
        Schema::table('bank_accounts', function (Blueprint $table) {
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
        Schema::dropIfExists('bank_accounts');
    }
}
