<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusColumnCashDailyBalanceSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cash_daily_balance_sessions', function($table)
        {

//            status opening_balance_draft=0; opening_balance_start=1, closing_balance_draft=2; closing_balance_done=3,

            $table->smallInteger('status')->default(0)->after('project_id');
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
