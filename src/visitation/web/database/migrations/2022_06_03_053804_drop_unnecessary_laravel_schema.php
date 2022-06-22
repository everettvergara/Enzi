<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DropUnnecessaryLaravelSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('locations');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('regions');

        \DB::unprepared("DROP PROCEDURE sp_call_mod_user_access;");
        \DB::statement("DROP VIEW vw_sys_mf_mod_group;");

        Schema::dropIfExists('tb_crm_tr_sample');

        Schema::table('tb_sys_mf_user', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('tb_sys_mf_status', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('tb_sys_mf_mod_group', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('tb_sys_mf_mod', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('tb_sys_mf_config', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('tb_sys_mf_approval_hierarchy_type', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('tb_sys_mf_access_type', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::dropIfExists('tb_sys_mf_status');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->onDelete('cascade')->constrained('countries', 'id');
            $table->foreignId('region_id')->onDelete('cascade')->constrained('regions', 'id');
            $table->foreignId('city_id')->onDelete('cascade')->constrained('cities', 'id');
            $table->string('name', 255);
            $table->timestamps();
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->foreignId('country_id')->onDelete('cascade')->constrained('countries', 'id');
            $table->foreignId('region_id')->onDelete('cascade')->constrained('regions', 'id');
            $table->timestamps();
        });

        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->foreignId('country_id')->onDelete('cascade')->constrained('countries', 'id');
            $table->timestamps();
        });

        \DB::unprepared("
                            create procedure sp_call_mod_user_access(@user_id bigint)
                            as
                            BEGIN
                                    SET NOCOUNT ON;
                                    select	distinct a.name as mod_name, a.id as mod_id, a.mod_group_id , a.url
                                    into	tmp_modules
                                    from 	tb_sys_mf_mod as a 
                                            
                                                    inner join tb_sys_mf_mod_access_type as b on 
                                                    a.id = b.mod_id 
                                            
                                                    inner join tb_sys_mf_user_access_type as c on 
                                                    b.access_type_id = c.access_type_id 
                                            
                                                    inner join tb_sys_mf_user as d on
                                                    c.user_id = d.id
                                            
                                    where 	d.id = @user_id
                                    ;
                            
                                    select * into tmp_modules_copy from tmp_modules;
                                    select * into tmp_sys_mf_mod_group from vw_sys_mf_mod_group order by seq;
                            
                                    select x.mod_name, x.mod_id, '' as mod_group_name,  y.level+1 as level, x.mod_group_id, y.seq+y.level+1 as seq, x.url  
                                    from 	tmp_modules_copy as x
                            
                                                    inner join tmp_sys_mf_mod_group as y on
                                                    x.mod_group_id = y.mod_group_id
                            
                                    union  
                                    select '' as mod_name, 0, c.mod_group_name, c.level, c.mod_group_id, c.seq, null as url
                                    from 	tmp_modules as a 
                            
                                                    inner join tmp_sys_mf_mod_group as b on
                                                    a.mod_group_id = b.mod_group_id 
                                            
                                                    inner join tmp_sys_mf_mod_group as c on 
                                                    c.seq like left(b.seq,1)+'%'
                                    order by seq, mod_name 
                                    ;
                            
                                    drop table tmp_modules;
                                    drop table tmp_modules_copy;
                                    drop table tmp_sys_mf_mod_group;
                            
                            END
                    ");
        
        \DB::statement("
                        CREATE view vw_sys_mf_mod_group AS

                        WITH mod_group (mod_group_id,mod_group_name,ref_mod_id,ref_mod_name,level,seq)
                        AS
                        (
                            select	
                                                a.id AS mod_group_id,
                                    a.name AS mod_group_name,
                                    cast(0 as bigint) AS ref_mod_id,
                                    a.name AS ref_mod_name,
                                    1 AS level,
                                    cast(a.seq as varchar) AS seq
                            from	tb_sys_mf_mod_group as a
                            where 	a.ref_mod_id is null
                                        
                                union 
                                all 	
                                        
                                select	a.id AS mod_group_id,
                                                a.name AS mod_group_name,
                                                a.ref_mod_id AS ref_mod_id,
                                                b.mod_group_name AS ref_mod_name,
                                                (b.level + 1) AS level,
                                                cast(cast(b.seq as varchar)+
                                                cast(a.seq as varchar) as varchar) AS seq
                                from	tb_sys_mf_mod_group as a 
                                                inner join mod_group as b on a.ref_mod_id = b.mod_group_id
                        )
                        select	mod_group.mod_group_id AS mod_group_id,
                                mod_group.mod_group_name AS mod_group_name
                                ,mod_group.ref_mod_id AS ref_mod_id,
                                mod_group.ref_mod_name AS ref_mod_name,
                                mod_group.level AS level,
                                mod_group.seq AS seq
                        from	mod_group");
        
        $sample_def_date = Carbon::now('UTC');
        Schema::create('tb_crm_tr_sample', function (Blueprint $table) use ($sample_def_date) {
            $table->id();
            $table->date('sample_date')->default($sample_def_date);
            $table->string('code', 30);
            $table->string('name', 255);
            $table->text('remarks')->nullable();
            $table->foreignId('status_id')->constrained('tb_sys_mf_status', 'id');
            $table->timestamps();
        });

        $is_active_def = 1;

        Schema::table('tb_sys_mf_access_type', function (Blueprint $table) use($is_active_def) {
            $table->boolean('is_active')->default($is_active_def)->nullable();
        });

        Schema::table('tb_sys_mf_approval_hierarchy_type', function (Blueprint $table) use($is_active_def) {
            $table->boolean('is_active')->default($is_active_def)->nullable();
        });

        Schema::table('tb_sys_mf_config', function (Blueprint $table) use($is_active_def) {
            $table->boolean('is_active')->default($is_active_def)->nullable();
        });

        Schema::table('tb_sys_mf_mod', function (Blueprint $table) use($is_active_def) {
            $table->boolean('is_active')->default($is_active_def)->nullable();
        });

        Schema::table('tb_sys_mf_mod_group', function (Blueprint $table) use($is_active_def) {
            $table->boolean('is_active')->default($is_active_def)->nullable();
        });

        Schema::table('tb_sys_mf_status', function (Blueprint $table) use($is_active_def){
            $table->boolean('is_active')->default($is_active_def)->nullable();
        });

        Schema::table('tb_sys_mf_user', function (Blueprint $table) use($is_active_def) {
            $table->boolean('is_active')->default($is_active_def)->nullable();
        });

        Schema::create('tb_sys_mf_status', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30);
            $table->string('name', 255);
            $table->boolean('is_for_posting')->nullable();
            $table->boolean('is_cancelled')->nullable();
            $table->boolean('is_posted')->nullable();
            $table->timestamps();
        });
    }
}
