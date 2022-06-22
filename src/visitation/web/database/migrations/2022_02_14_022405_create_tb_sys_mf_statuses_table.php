<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbSysMfStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_sys_mf_status', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30);
            $table->string('name', 255);
            $table->boolean('is_for_posting')->nullable();
            $table->boolean('is_cancelled')->nullable();
            $table->boolean('is_posted')->nullable();
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
        Schema::dropIfExists('tb_sys_mf_status');
    }
}
