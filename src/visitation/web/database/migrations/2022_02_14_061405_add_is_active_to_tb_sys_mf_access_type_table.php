<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveToTbSysMfAccessTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $value = 1;

        Schema::table('tb_sys_mf_access_type', function (Blueprint $table) use($value) {
            $table->boolean('is_active')->default($value)->nullable();
        });

        Schema::table('tb_sys_mf_approval_hierarchy_type', function (Blueprint $table) use($value) {
            $table->boolean('is_active')->default($value)->nullable();
        });

        Schema::table('tb_sys_mf_config', function (Blueprint $table) use($value) {
            $table->boolean('is_active')->default($value)->nullable();
        });

        Schema::table('tb_sys_mf_mod', function (Blueprint $table) use($value) {
            $table->boolean('is_active')->default($value)->nullable();
        });

        Schema::table('tb_sys_mf_mod_group', function (Blueprint $table) use($value) {
            $table->boolean('is_active')->default($value)->nullable();
        });

        Schema::table('tb_sys_mf_status', function (Blueprint $table) use($value){
            $table->boolean('is_active')->default($value)->nullable();
        });

        Schema::table('tb_sys_mf_user', function (Blueprint $table) use($value) {
            $table->boolean('is_active')->default($value)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_sys_mf_user', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('tb_sys_mf_status', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('tb_sys_mf_mod_group', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('tb_sys_mf_mod', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('tb_sys_mf_config', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('tb_sys_mf_approval_hierarchy_type', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('tb_sys_mf_access_type', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

    }
}
