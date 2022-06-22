<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbCrmTrSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $value = Carbon::now('UTC');

        Schema::create('tb_crm_tr_sample', function (Blueprint $table) use ($value) {
            $table->id();
            $table->date('sample_date')->default($value);
            $table->string('code', 30);
            $table->string('name', 255);
            $table->text('remarks')->nullable();
            $table->foreignId('status_id')->constrained('tb_sys_mf_status', 'id');
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
        Schema::dropIfExists('tb_crm_tr_sample');
    }
}