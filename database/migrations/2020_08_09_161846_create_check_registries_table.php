<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckRegistriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_registries', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('check_mode', array('IN','OUT'));
            $table->enum('check_type', array('CASH','ACCOUNT_PAY'));
            $table->string('check_number')->nullable();
            $table->date('check_date')->nullable();
            $table->decimal('amount',10, 2)->default(0);
            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('project_id')->unsigned()->nullable();
            $table->integer('bank_id')->unsigned()->nullable();
            $table->integer('branch_id')->unsigned()->nullable();
            $table->integer('bank_account_id')->unsigned()->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
        });
        Schema::table('check_registries', function($table) {
            $table->foreign('company_id')->references('id')->on('companies');
        });
        Schema::table('check_registries', function($table) {
            $table->foreign('project_id')->references('id')->on('projects');
        });
        Schema::table('check_registries', function($table) {
            $table->foreign('bank_account_id')->references('id')->on('bank_accounts');
        });
        Schema::table('check_registries', function($table) {
            $table->foreign('created_by')->references('id')->on('users');
        });
        Schema::table('check_registries', function($table) {
            $table->foreign('bank_id')->references('id')->on('bank_and_branches');
        });
        Schema::table('check_registries', function($table) {
            $table->foreign('branch_id')->references('id')->on('bank_and_branches');
        });
        Schema::table('check_registries', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('check_registries');
    }
}
