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
            $table->string('file')->nullable();
            $table->string('voucher_id')->nullable();

            $table->timestamps();
        });

        Schema::table('vochers', function($table) {
            $table->foreign('user_id')->references('id')->on('users');

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
