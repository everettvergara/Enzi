<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVwSysMfModGroupView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        switch (true) {
                case env('DB_CONNECTION') == "sqlsrv":
                        $view = "CREATE view vw_sys_mf_mod_group AS

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
                        from	mod_group";
                        break;
                
                default:
                        $view = "CREATE VIEW vw_sys_mf_mod_group AS
                        with recursive mod_group (mod_group_id,mod_group_name,ref_mod_id,ref_mod_name,level,seq) 
                        as 
                        (select	a.id AS mod_group_id,
                                a.name AS mod_group_name,
                                0 AS ref_mod_id,
                                a.name AS ref_mod_name,
                                1 AS level,
                                cast(a.seq as char charset utf8mb4) AS seq 
                        from	laravel_demo.tb_sys_mf_mod_group a 
                        where 	(a.ref_mod_id is null) 
                        
                        union 
                        all 	
                        
                        select	a.id AS mod_group_id,
                                a.name AS mod_group_name,
                                a.ref_mod_id AS ref_mod_id,
                                b.mod_group_name AS ref_mod_name,
                                (b.level + 1) AS level,
                                cast(b.seq as char charset utf8mb4)+
                                cast(a.seq as char charset utf8mb4) AS seq 
                        from	(laravel_demo.tb_sys_mf_mod_group a 
                                join mod_group b on((a.ref_mod_id = b.mod_group_id)))) 
                        
                        select	mod_group.mod_group_id AS mod_group_id,
                                mod_group.mod_group_name AS mod_group_name
                                ,mod_group.ref_mod_id AS ref_mod_id,
                                mod_group.ref_mod_name AS ref_mod_name,
                                mod_group.level AS level,
                                mod_group.seq AS seq
                        from	mod_group 
                        order by mod_group.seq";
                        break;
        }
        \DB::statement($view);
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
                        $view = "DROP VIEW vw_sys_mf_mod_group;";
                        break;
                
                default:
                        $view = "DROP VIEW IF EXISTS `vw_sys_mf_mod_group`;";
                        break;
        }

        \DB::statement($view);
    }

}
