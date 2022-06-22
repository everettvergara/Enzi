<?php

namespace Database\Seeders;

use App\Models\tb_sys_mf_access_type;
use Database\Factories\AccessTypeFactory;
use Illuminate\Database\Seeder;

class AccessTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $existing = tb_sys_mf_access_type::whereIn('code', ['PROG', 'CL'])->get();
        $existing_count = $existing->count();

        if($existing_count == 0){
            // tb_sys_mf_access_type::create([
            //     'name' => 'Full Access',
            //     'code' => 'FA',
            //     'is_active' => 1
            // ]);

            $fa = new tb_sys_mf_access_type();
            unset($fa->sortable);
            $fa->fill([
                'name' => 'Full Access',
                'code' => 'FA',
                'is_active' => 1
            ]);
            $fa->save();
        
            // tb_sys_mf_access_type::create([
            //     'name' => 'Programmer',
            //     'code' => 'PROG',
            //     'is_active' => 1
            // ]);

            $prog = new tb_sys_mf_access_type();
            unset($prog->sortable);
            $prog->fill([
                'name' => 'Programmer',
                'code' => 'PROG',
                'is_active' => 1
            ]);
            $prog->save();
    
            // tb_sys_mf_access_type::create([
            //     'name' => 'Client',
            //     'code' => 'CL',
            //     'is_active' => 1
            // ]);

            $cl = new tb_sys_mf_access_type();
            unset($cl->sortable);
            $cl->fill([
                'name' => 'Client',
                'code' => 'CL',
                'is_active' => 1
            ]);
            $cl->save();
        }

        // $count = max((int)$this->command->ask('How many access types would you like?', 10), 1);
        // AccessTypeFactory::factory($count)->create();
    }
}
