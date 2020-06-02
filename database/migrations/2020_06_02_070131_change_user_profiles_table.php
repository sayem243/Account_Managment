<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('mothername')->nullable()->change();
            $table->string('fathername')->nullable()->change();
            $table->string('p_address')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('joindate')->nullable()->change();
            $table->string('nid')->nullable()->change();
            $table->string('mobile')->nullable()->change();

            $table->dropColumn('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
