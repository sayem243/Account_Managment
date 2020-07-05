<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBankIdFieldBankAndBranchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank_and_branches', function($table)
        {
            $table->integer('bank_id')->unsigned()->nullable()->after('name');
        });
        Schema::table('bank_and_branches', function($table) {
            $table->foreign('bank_id')->references('id')->on('bank_and_branches');

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
