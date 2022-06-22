<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->onDelete('cascade')->constrained('countries', 'id');
            $table->foreignId('region_id')->onDelete('cascade')->constrained('regions', 'id');
            $table->foreignId('city_id')->onDelete('cascade')->constrained('cities', 'id');
            $table->string('name', 255);
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
        Schema::dropIfExists('locations');
    }
}
