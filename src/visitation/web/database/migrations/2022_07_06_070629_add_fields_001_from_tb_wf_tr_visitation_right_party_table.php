<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFields001FromTbWfTrVisitationRightPartyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_wf_tr_visitation_right_party', function (Blueprint $table) {
            $table->string('printed_name', 255)->nullable();
            $table->datetime('time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_wf_tr_visitation_right_party', function (Blueprint $table) {
            $table->dropColumn('printed_name');
            $table->dropColumn("time");
        });
    }
}
