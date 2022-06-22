<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpCallModUserAccessStoredProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        switch (true) {
                case    env('DB_CONNECTION') == "sqlsrv":
                        $procedure = "
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
                        ";
                        break;
                
                default:
                        $procedure = "
                                        CREATE PROCEDURE `sp_call_mod_user_access`(user_id bigint)
                                        BEGIN
                                        create temporary table tmp_modules
                                        select	distinct a.name as mod_name, a.id as mod_id, a.mod_group_id , a.url
                                        from 	tb_sys_mf_mod as a 
                                                
                                                inner join tb_sys_mf_mod_access_type as b on 
                                                a.id = b.mod_id 
                                                
                                                inner join tb_sys_mf_user_access_type as c on 
                                                b.access_type_id = c.access_type_id 
                                                
                                                inner join tb_sys_mf_user as d on 
                                                c.user_id = d.id 
                                                
                                        /*        inner join vw_sys_mf_mod_group as e on 
                                                a.mod_group_id = e.mod_group_id 
                                        
                                                inner join tmp_tb_sys_mf_mod_group as f on 
                                                f.seq like concat(left(e.seq, 1), '%') */
                                        where 	d.id = user_id
                                        ;
                                        create temporary table tmp_modules_copy 
                                        select * from tmp_modules;
                                
                                        select x.mod_name, x.mod_id, '' as mod_group_name,  y.level+1 as level, x.mod_group_id, concat(y.seq, y.level+1) as seq, x.url  
                                        from 	tmp_modules_copy as x
                                
                                                inner join vw_sys_mf_mod_group as y on
                                                x.mod_group_id = y.mod_group_id 
                                
                                        union  
                                        select '' as mod_name, 0, c.mod_group_name, c.level, c.mod_group_id, c.seq, null as url
                                        from 	tmp_modules as a 
                                
                                                inner join vw_sys_mf_mod_group as b on
                                                a.mod_group_id = b.mod_group_id 
                                                
                                                inner join vw_sys_mf_mod_group as c on 
                                                c.seq like concat(left(b.seq,1), '%')
                                        order by seq, mod_name 
                                        ;
                                
                                        drop table tmp_modules;
                                        drop table tmp_modules_copy;
                                        END;
                                ";
                        break;
        }

        return \DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        switch (true) {
                case env('DB_CONNECTION') == "sqlsrv":
                        $procedure = "DROP PROCEDURE sp_call_mod_user_access;";
                        break;
                
                default:
                        $procedure = "DROP PROCEDURE IF EXISTS `sp_call_mod_user_access`;";
                        break;
        }

        return \DB::unprepared($procedure);
    }
}
