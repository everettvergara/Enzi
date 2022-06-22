<?php

namespace Database\Seeders;

use App\Models\tb_sys_mf_mod_group;
use Database\Factories\ModuleGroupFactory;
use Illuminate\Database\Seeder;

class ModuleGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $existing = tb_sys_mf_mod_group::whereIn('code', ['PR', 'SYS', 'MF', 'TR', 'RP','TL', 'SC', 'CFG'])->get();
        $existing_count = $existing->count();

        if($existing_count == 0){
            $pr =   tb_sys_mf_mod_group::create([
                        'code' => 'PR',
                        'name' => 'PATIENT REGISTRY',
                        'menu' => 'patient-registry',
                        'ref_mod_id' => null,
                        'seq' => 1,
                        'is_active' => 1,
                    ]);
            $sys =   tb_sys_mf_mod_group::create([
                'code' => 'SYS',
                'name' => 'SYSTEM',
                'menu' => 'system',
                'ref_mod_id' => null,
                'seq' => 2,
                'is_active' => 1,
            ]);

            tb_sys_mf_mod_group::create([
                'code' => 'MF',
                'name' => 'MASTER FILES',
                'menu' => 'master-files',
                'ref_mod_id' => $pr->id,
                'seq' => 1,
                'is_active' => 1,
            ]);

            tb_sys_mf_mod_group::create([
                'code' => 'transactions',
                'name' => 'TRANSACTIONS',
                'menu' => 'TR',
                'ref_mod_id' => $pr->id,
                'seq' => 2,
                'is_active' => 1,
            ]);

            tb_sys_mf_mod_group::create([
                'code' => 'RP',
                'name' => 'REPORTS',
                'menu' => 'reports',
                'ref_mod_id' => $pr->id,
                'seq' => 3,
                'is_active' => 1,
            ]);

            tb_sys_mf_mod_group::create([
                'code' => 'TL',
                'name' => 'TOOLS',
                'menu' => 'tools',
                'ref_mod_id' => $sys->id,
                'seq' => 1,
                'is_active' => 1,
            ]);

            tb_sys_mf_mod_group::create([
                'code' => 'SC',
                'name' => 'SECURITY',
                'menu' => 'security',
                'ref_mod_id' => $sys->id,
                'seq' => 2,
                'is_active' => 1,
            ]);


            tb_sys_mf_mod_group::create([
                'code' => 'CFG',
                'name' => 'CONFIGURATIONS',
                'menu' => 'configurations',
                'ref_mod_id' => $sys->id,
                'seq' => 3,
                'is_active' => 1,
            ]);
        }

        // $count = max((int)$this->command->ask('How many module groups would you like?', 10), 1);
        // ModuleGroupFactory::factory($count)->create();
    }
}
