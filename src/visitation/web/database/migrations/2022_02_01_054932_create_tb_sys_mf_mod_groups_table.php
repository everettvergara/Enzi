<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbSysMfModGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_sys_mf_mod_group', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->foreignId('ref_mod_id')->nullable()->constrained('tb_sys_mf_mod_group', 'id');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_sys_mf_mod_group');
    }
}
