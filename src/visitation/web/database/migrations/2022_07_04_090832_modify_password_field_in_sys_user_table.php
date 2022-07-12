<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPasswordFieldInSysUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_user', function (Blueprint $table) {
            $table->string("password", 4096)->change();
            $table->bigInteger("user_id")->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_user', function (Blueprint $table) {
            
        });
    }
}
