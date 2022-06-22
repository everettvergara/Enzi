<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModGroupIdToTbSysMfModTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_sys_mf_mod', function (Blueprint $table) {
            $table->foreignId('mod_group_id')->constrained('tb_sys_mf_mod_group', 'id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_sys_mf_mod', function (Blueprint $table) {
            $table->dropForeign(['mod_group_id']);
            $table->dropColumn('mod_group_id');
            
        });
    }
}
