<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCheckRegistryIdColumnVoucherItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('voucher_items', function($table)
        {
            $table->integer('check_registry_id')->unsigned()->nullable()->after('project_id');
        });

        Schema::table('voucher_items', function($table) {
            $table->foreign('check_registry_id')->references('id')->on('check_registries');
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
