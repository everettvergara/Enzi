<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMenuToTbSysMfModGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_sys_mf_mod_group', function (Blueprint $table) {
            $table->string('menu', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_sys_mf_mod_group', function (Blueprint $table) {
            $table->dropColumn('menu');
        });
    }
}
