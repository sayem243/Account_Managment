<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');

            //$table->integer('project_id')->unsigned()->nullable();


            $table->string('name');

            $table->string('c_email')->unique();
            $table->string('c_mobile');
            $table->string('c_address');
            $table->string('c_img')->nullable();

            $table->timestamps();
        });



        Schema::table('companies', function (Blueprint $table) {
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
        Schema::dropIfExists('companies');
    }
}
