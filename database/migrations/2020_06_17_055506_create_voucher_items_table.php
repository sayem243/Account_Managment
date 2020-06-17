<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoucherItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item_name',200)->nullable();
            $table->integer('voucher_id')->unsigned()->nullable();

            $table->decimal('payment_amount',10, 2)->default(0);
            $table->decimal('voucher_amount',10, 2)->default(0);
            $table->integer('payment_id')->unsigned()->nullable();
            $table->integer('payment_details_id')->unsigned()->nullable();
            $table->integer('project_id')->unsigned()->nullable();
            $table->smallInteger('status')->default(0);

            $table->timestamps();
        });

        Schema::table('voucher_items', function($table) {
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('cascade');;
        });

        Schema::table('voucher_items', function($table) {
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');;
        });

        Schema::table('voucher_items', function($table) {
            $table->foreign('payment_details_id')->references('id')->on('payment_details')->onDelete('cascade');
        });

        Schema::table('voucher_items', function($table) {
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voucher_items');
    }
}
