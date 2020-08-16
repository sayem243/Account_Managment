<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashDailyBalanceSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_daily_balance_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('opening_balance',10, 2)->default(0);
            $table->decimal('closing_balance',10, 2)->default(0);
            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('project_id')->unsigned()->nullable();
            $table->timestamps();
        });
        Schema::table('cash_daily_balance_sessions', function($table) {
            $table->foreign('company_id')->references('id')->on('companies');
        });
        Schema::table('cash_daily_balance_sessions', function($table) {
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
        Schema::dropIfExists('cash_daily_balance_sessions');
    }
}
