<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDisbursedFieldPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function($table)
        {
            $table->integer('disbursed_by')->unsigned()->nullable()->after('approved_by');
            $table->dateTime('disbursed_at')->nullable()->after('approved_at');
        });

        Schema::table('payments', function($table) {
            $table->foreign('disbursed_by')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
