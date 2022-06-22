<?php

namespace Database\Seeders;

use App\Models\tb_sys_mf_access_type;
use App\Models\tb_sys_mf_user;
use App\Models\tb_sys_mf_user_access_type;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $existing = tb_sys_mf_user::where('name', 'System Administrator')->first();
        $hashed_pw = Hash::make('Kerberos2014!');
        $admin_access = tb_sys_mf_access_type::where('code', 'FA')->first();

        if(!isset($existing)){
            tb_sys_mf_user::create([
                'name' => 'System Administrator',
                'email' => 'evergara@shinra.com.ph',
                'email_verified_at' => now(),
                'password' => $hashed_pw,
                'image_path' => 'default.png',
                'is_admin' => 1,
                'is_active' => 1,
                'remember_token' => Str::random(10),
            ])->each(function ($user) use ($admin_access) {
                $user_access = tb_sys_mf_user_access_type::make();
                $user_access->user_id = $user->id;
                $user_access->access_type_id =  $admin_access->id;
                $user_access->save();
            });
        }

        // $count = max((int)$this->command->ask('How many users would you like?', 10), 1);
        // UserFactory::factory($count)->create()->each(function ($user) use ($access) {
        //     tb_sys_mf_user_access_type::create([
        //         'user_id' => $user->id,
        //         'access_id' => $access->id
        //     ]);
        // });
    }
}
