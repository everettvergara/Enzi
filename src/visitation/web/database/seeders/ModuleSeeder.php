<?php

namespace Database\Seeders;

use App\Models\tb_sys_mf_access_type;
use App\Models\tb_sys_mf_mod;
use App\Models\tb_sys_mf_mod_access_type;
use App\Models\tb_sys_mf_mod_group;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $existing = tb_sys_mf_mod::whereIn('code', ['MOD', 'MODG', 'USER', 'ACCESS', 'APR', 'VAR', 'STATUS', 'STR'])->get();
        $existing_count = $existing->count();

        $sc = tb_sys_mf_mod_group::where('code', 'SC')->first();
        $cfg = tb_sys_mf_mod_group::where('code', 'CFG')->first();
        $access = tb_sys_mf_access_type::where('code', 'FA')->first();


        if($existing_count == 0){
            // $module_mod = tb_sys_mf_mod::create([
            //     'code' => 'MOD',
            //     'name' => 'Module',
            //     'menu' => 'mod',
            //     'mod_group_id' => $sc->id,
            //     'url' => 'mods',
            //     'is_active' => 1
            // ])->each(function ($mod) use ($access){
            //     $mod_access = tb_sys_mf_mod_access_type::make();
            //     $mod_access->mod_id = $mod->id;
            //     $mod_access->access_type_id = $access->id;
            //     $mod_access->save();
            // });

            $module_mod = tb_sys_mf_mod::create([
                'code' => 'MOD',
                'name' => 'Module',
                'menu' => 'mod',
                'mod_group_id' => $sc->id,
                'url' => 'mods',
                'is_active' => 1
            ]);

            $mod_group_mod = tb_sys_mf_mod::create([
                'code' => 'MODG',
                'name' => 'Module Group',
                'menu' => 'module-group',
                'mod_group_id' => $sc->id,
                'url' => 'mod-groups',
                'is_active' => 1
            ]);

            $user = tb_sys_mf_mod::create([
                'code' => 'USER',
                'name' => 'User',
                'menu' => 'user',
                'mod_group_id' => $sc->id,
                'url' => 'users',
                'is_active' => 1
            ]);

            $access_mod = tb_sys_mf_mod::create([
                'code' => 'ACCESS',
                'name' => 'Access Type',
                'menu' => 'access-type',
                'mod_group_id' => $sc->id,
                'url' => 'access-types',
                'is_active' => 1
            ]);

            $apr_mod = tb_sys_mf_mod::create([
                'code' => 'APR',
                'name' => 'Approval Type',
                'menu' => 'approval-type',
                'mod_group_id' => $sc->id,
                'url' => 'apr-types',
                'is_active' => 1
            ]);

            $status_mod = tb_sys_mf_mod::create([
                'code' => 'STATUS',
                'name' => 'Status',
                'menu' => 'status',
                'mod_group_id' => $sc->id,
                'url' => 'statuses',
                'is_active' => 1
            ]);

            $var_mod = tb_sys_mf_mod::create([
                'code' => 'VAR',
                'name' => 'Variables',
                'menu' => 'variables',
                'mod_group_id' => $cfg->id,
                'url' => 'configs',
                'is_active' => 1
            ]);

            $existing_mods = tb_sys_mf_mod::all();
            foreach($existing_mods as $mod){
                $mod_access = tb_sys_mf_mod_access_type::make();
                $mod_access->mod_id = $mod->id;
                $mod_access->access_type_id = $access->id;
                $mod_access->save();
            }
        }
    }
}
