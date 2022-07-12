<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFields002FromTbWfTrVisitationDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_wf_tr_visitation_detail', function (Blueprint $table) {
            $table->date('date_visited')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_wf_tr_visitation_detail', function (Blueprint $table) {
            $table->dropColumn('date_visited');
        });
    }
}
