<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdApprovalTypeIdToTbSysMfUserApprovalHierarchyTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_sys_mf_user_approval_hierarchy_type', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('tb_sys_mf_user')->onDelete('cascade')->constrained();
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
        Schema::table('tb_sys_mf_user_approval_hierarchy_type', function (Blueprint $table) {
            $table->dropForeign(['approval_type_id']);
            $table->dropColumn('approval_type_id');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
