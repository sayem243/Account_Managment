<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->double('total_demand_amount', 10, 2);
            $table->double('total_paid_amount',10, 2);
            $table->decimal('total_amendment_amount',10, 2)->default(0);

            $table->integer('company_id')->unsigned()->nullable();

            $table->integer('user_id')->unsigned()->nullable();

            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('verified_by')->unsigned()->nullable();
            $table->integer('approved_by')->unsigned()->nullable();

            $table->smallInteger('status')->default(1);
            $table->dateTime('verified_at')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->string('comments')->nullable();
            $table->string('payment_id')->nullable();

            $table->boolean('enable')->default(1);
            $table->timestamps();
        });


        Schema::table('payments', function($table) {
            $table->foreign('company_id')->references('id')->on('companies');

        });

        Schema::table('payments', function($table) {
            $table->foreign('user_id')->references('id')->on('users');

        });

        Schema::table('payments', function($table) {
            $table->foreign('created_by')->references('id')->on('users');

        });

        Schema::table('payments', function($table) {
            $table->foreign('verified_by')->references('id')->on('users');

        });

        Schema::table('payments', function($table) {
            $table->foreign('approved_by')->references('id')->on('users');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
