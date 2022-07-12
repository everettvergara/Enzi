<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbWfTrVisitationThirdPartyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_wf_tr_visitation_third_party', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('visitation_detail_id');
            $table->string('printed_name', 255)->nullable();
            $table->string('signature', 1023)->nullable();
            $table->string('attachment', 1023)->nullable();
            $table->string('relationship', 255)->nullable();
            $table->string('mobile_no', 255)->nullable();
            $table->string('landline_no', 255)->nullable();
            $table->string('whereabouts', 255)->nullable();
            $table->string('work', 255)->nullable();
            $table->string('work_address', 1023)->nullable();
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
        Schema::dropForeign('tb_wf_tr_visitation_third_party_visitation_detail_id_foreign');
        Schema::dropIfExists('tb_wf_tr_visitation_third_party');
    }
}
