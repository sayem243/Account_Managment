<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFromToColumnCheckRegistryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('check_registries', function($table)
        {
            $table->enum('from_to_type',array('USER','COMPANY','PROJECT','CLIENT','OTHERS'))->after('amount');
            $table->string('from_to_value')->after('amount');
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
