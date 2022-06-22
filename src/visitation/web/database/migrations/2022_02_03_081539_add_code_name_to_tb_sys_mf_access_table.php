<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodeNameToTbSysMfAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_sys_mf_access_type', function (Blueprint $table) {
            $table->string('code', 30);
            $table->string('name', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_sys_mf_access_type', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('code');
        });
    }
}
