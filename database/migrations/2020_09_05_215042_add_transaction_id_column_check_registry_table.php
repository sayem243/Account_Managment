<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransactionIdColumnCheckRegistryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('check_registries', function($table)
        {
            $table->integer('cash_transaction_id')->unsigned()->nullable()->after('bank_account_id');;
        });

        Schema::table('check_registries', function($table) {
            $table->foreign('cash_transaction_id')->references('id')->on('cash_transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
