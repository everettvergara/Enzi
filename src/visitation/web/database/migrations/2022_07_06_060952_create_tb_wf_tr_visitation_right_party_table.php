<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbWfTrVisitationRightPartyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_wf_tr_visitation_right_party', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('visitation_detail_id');
            $table->string('signature', 1023)->nullable();
            $table->string('attachment', 1023)->nullable();
            $table->string('mobile_no', 255)->nullable();
            $table->string('landline_no', 255)->nullable();
            $table->string('email_address', 255)->nullable();
            $table->string('reason_for_default', 1023)->nullable();
            $table->date('ptp_date')->nullable();
            $table->float('ptp_amount')->nullable();
            $table->datetime('best_time_to_call')->nullable();
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
        Schema::dropForeign('tb_wf_tr_visitation_right_party_visitation_detail_id_foreign');
        Schema::dropIfExists('tb_wf_tr_visitation_right_party');
    }
}
