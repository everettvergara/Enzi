<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbWfTrVisitationNegativeParty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_wf_tr_visitation_negative_party', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('visitation_detail_id');
            $table->string('reason', 1023)->nullable();
            $table->string('source_of_information', 1023)->nullable();
            $table->datetime('time')->nullable();            
            $table->foreign('visitation_detail_id')->references('id')->on('tb_wf_tr_visitation_detail')->onDelete('cascade');
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
        Schema::dropForeign('tb_wf_tr_visitation_negative_party_visitation_detail_id_foreign');
        Schema::dropIfExists('tb_wf_tr_visitation_negative_party');
    }
}
