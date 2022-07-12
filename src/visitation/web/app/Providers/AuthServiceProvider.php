<?php

namespace App\Providers;

use App\Models\tb_sys_mf_access_type;
use App\Models\tb_sys_mf_mod;
use App\Models\tb_sys_mf_mod_access_type;
use App\Models\tb_sys_mf_user;
use App\Models\tb_sys_mf_user_access_type;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        // 'App\Models\tb_sys_mf_user' => 'App\Policies\UserPolicy',
        'App\Models\sys_user' => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if (! $this->app->routesAreCached()) {
            Passport::routes();
        }

        // Gate::define('has_access', function ($user, $mod_code)
        // {
        //     $user_access = tb_sys_mf_user_access_type::where('user_id', $user->id)->get()->pluck('access_type_id')->toArray();
        //     $mod = tb_sys_mf_mod::where('code', $mod_code)->get()->first();
        //     $mod_access = tb_sys_mf_mod_access_type::where('mod_id', $mod->id)->get()->pluck('access_type_id')->toArray();
        //     foreach($mod_access as $access){
        //         if(in_array($access, $user_access)){
        //             return true;
        //         }
        //     }
        //     return false;
        // });

        // Gate::before(function ($user, $ability){

        //     $full_access = tb_sys_mf_access_type::where('code','FA')->first(); //Get FA/Full Access in Access Type Masterfile
        //     $user_access = tb_sys_mf_user_access_type::where('user_id', $user->id)->where('access_type_id', $full_access->id)->first(); //check if user has full access
        //     if(isset($user_access) && in_array($ability, ['update', 'route_users', 'route_mods', 'route_mod_groups','route_access', 'route_apr', 'route_status', 'route_var'])){
        //         return true;
        //     }
        // });
    }
}
