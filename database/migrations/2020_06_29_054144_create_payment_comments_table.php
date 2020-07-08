<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('comments')->nullable();

            $table->integer('payment_id')->unsigned()->nullable();

            $table->integer('created_by')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('payment_comments', function($table) {
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');

        });

        Schema::table('payment_comments', function($table) {
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_comments');
    }
}
