<?php

namespace Database\Seeders;

use App\Models\tb_sys_mf_status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $existing = tb_sys_mf_status::whereIn('code', ['posting', 'posted', 'cancel'])->get();
        $existing_count = $existing->count();

        if($existing_count == 0){
            // tb_sys_mf_status::create([
            //     'code' => 'posting',
            //     'name' => 'For Posting',
            //     'is_for_posting' => 1,
            //     'is_cancelled' => 0,
            //     'is_posted' => 0,
            //     'is_active' => 1,
            // ]);

            $posting = new tb_sys_mf_status();
            unset($posting->sortable);
            $posting->fill([
                'code' => 'posting',
                'name' => 'For Posting',
                'is_for_posting' => 1,
                'is_cancelled' => 0,
                'is_posted' => 0,
                'is_active' => 1,
            ]);
            $posting->save();

            // tb_sys_mf_status::create([
            //     'code' => 'posted',
            //     'name' => 'Posted',
            //     'is_for_posting' => 0,
            //     'is_cancelled' => 0,
            //     'is_posted' => 1,
            //     'is_active' => 1,
            // ]);

            $posted = new tb_sys_mf_status();
            unset($posted->sortable);
            $posted->fill([
                'code' => 'posted',
                'name' => 'Posted',
                'is_for_posting' => 0,
                'is_cancelled' => 0,
                'is_posted' => 1,
                'is_active' => 1,
            ]);
            $posted->save();

            // tb_sys_mf_status::create([
            //     'code' => 'cancel',
            //     'name' => '	Cancelled',
            //     'is_for_posting' => 0,
            //     'is_cancelled' => 1,
            //     'is_posted' => 0,
            //     'is_active' => 1,
            // ]);

            $cancel = new tb_sys_mf_status();
            unset($cancel->sortable);
            $cancel->fill([
                'code' => 'cancel',
                'name' => '	Cancelled',
                'is_for_posting' => 0,
                'is_cancelled' => 1,
                'is_posted' => 0,
                'is_active' => 1,
            ]);
            $cancel->save();
        }
    }
}
