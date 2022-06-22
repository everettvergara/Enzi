<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSeqToTbSysMfModGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_sys_mf_mod_group', function (Blueprint $table) {
            $table->integer('seq')->nullable();
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
            $table->dropColumn('seq');
        });
    }
}
