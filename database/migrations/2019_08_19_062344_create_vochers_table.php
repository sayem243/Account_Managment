<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVochersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vochers', function (Blueprint $table) {
            $table->increments('id');

            $table->decimal('total_amount');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('comments')->nullable();
            $table->string('file')->nullable();
            $table->smallInteger('status')->default(1);
            $table->string('voucher_id')->nullable();
            $table->integer('payment_id')->unsigned()->nullable();

            $table->timestamps();
        });

        Schema::table('vochers', function($table) {
            $table->foreign('user_id')->references('id')->on('users');

        });

        Schema::table('vochers', function($table) {
            $table->foreign('payment_id')->references('id')->on('payments');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vochers');
    }
}
