<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySysUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('sys_user')) {
            Schema::table('sys_user', function (Blueprint $table) {
                $table->timestamp('email_verified_at')->nullable();
                $table->rememberToken();
                $table->timestamps();
                $table->boolean('is_admin')->nullable();
                $table->string('image_path', 255)->nullable();
            });
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
