<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Modify0001TbWfTrVisitationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("tb_wf_tr_visitation", function(Blueprint $table) {
            $table->bigInteger("user_id")->nullable();
            $table->foreign("user_id")->references("user_id")->on("sys_user");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropForeign("tb_wf_tr_visitation_user_id_foreign");
        $table->dropColumn("user_id");
    }
}
