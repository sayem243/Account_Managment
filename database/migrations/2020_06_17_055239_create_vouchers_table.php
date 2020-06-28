<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('voucher_generate_id')->nullable();
            $table->decimal('total_amount',10, 2)->default(0);
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('expenditure_sector_id')->unsigned()->nullable();
            $table->smallInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::table('vouchers', function($table) {
            $table->foreign('created_by')->references('id')->on('users');

        });
        Schema::table('vouchers', function($table) {
            $table->foreign('expenditure_sector_id')->references('id')->on('expenditure_sectors');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
}
