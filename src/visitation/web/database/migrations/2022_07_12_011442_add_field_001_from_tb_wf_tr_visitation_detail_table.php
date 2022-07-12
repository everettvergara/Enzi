<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddField001FromTbWfTrVisitationDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_wf_tr_visitation_detail', function (Blueprint $table) {
            $table->smallInteger('seq')->nullable();
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
            $table->dropColumn('seq');
        });
    }
}
