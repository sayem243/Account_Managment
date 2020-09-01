<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGenerateIdColumnCashAndIncomeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loans', function($table)
        {
            $table->string('loan_generate_id')->nullable()->after('id');
            $table->smallInteger('status')->default(1)->after('created_by');
        });

        Schema::table('incomes', function($table)
        {
            $table->string('income_generate_id')->nullable()->after('id');
            $table->smallInteger('status')->default(1)->after('created_by');
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
