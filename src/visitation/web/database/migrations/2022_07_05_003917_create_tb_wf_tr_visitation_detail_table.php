<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbWfTrVisitationDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_wf_tr_visitation_detail', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("visitation_id");
            $table->integer("cm_id");
            $table->foreign("visitation_id")->references("id")->on("tb_wf_tr_visitation")->onDelete("cascade");
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
        Schema::dropIfExists('tb_wf_tr_visitation_detail');
    }
}
