<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModIdAprIdToTbSysMfModApprovalHierarchyTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_sys_mf_mod_approval_hierarchy_type', function (Blueprint $table) {
            $table->unsignedBigInteger('mod_id');
            $table->foreign('mod_id')->references('id')->on('tb_sys_mf_mod')->onDelete('cascade')->constrained();
            $table->unsignedBigInteger('approval_type_id');
            $table->foreign('approval_type_id')->references('id')->on('tb_sys_mf_approval_hierarchy_type')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_sys_mf_mod_approval_hierarchy_type', function (Blueprint $table) {
            $table->dropForeign(['approval_type_id']);
            $table->dropColumn('approval_type_id');
            $table->dropForeign(['mod_id']);
            $table->dropColumn('mod_id');
        });
    }
}
