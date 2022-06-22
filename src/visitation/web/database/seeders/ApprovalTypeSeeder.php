<?php

namespace Database\Seeders;

use App\Models\tb_sys_mf_approval_hierarchy_type;
use Database\Factories\ApprovalTypeFactory;
use Illuminate\Database\Seeder;

class ApprovalTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $existing = tb_sys_mf_approval_hierarchy_type::whereIn('code', ['APR', 'ENC'])->get();
        $existing_count = $existing->count();

        if($existing_count == 0){
            // tb_sys_mf_approval_hierarchy_type::create([
            //     'code' => 'APR',
            //     'name' => 'Approver',
            //     'description' => 'Approver Type',
            //     'is_active' => 1
            // ]);

            $apr = new tb_sys_mf_approval_hierarchy_type();
            unset($apr->sortable);
            $apr->fill([
                'code' => 'APR',
                'name' => 'Approver',
                'description' => 'Approver Type',
                'is_active' => 1
            ]);
            $apr->save();

            // tb_sys_mf_approval_hierarchy_type::create([
            //     'code' => 'ENC',
            //     'name' => 'Encoder',
            //     'description' => 'Encoder Type',
            //     'is_active' => 1
            // ]);

            $enc = new tb_sys_mf_approval_hierarchy_type();
            unset($enc->sortable);
            $enc->fill([
                'code' => 'ENC',
                'name' => 'Encoder',
                'description' => 'Encoder Type',
                'is_active' => 1
            ]);
            $enc->save();
        }

        // $count = max((int)$this->command->ask('How many approval types would you like?', 10), 1);
        // ApprovalTypeFactory::factory($count)->create();

    }
}
