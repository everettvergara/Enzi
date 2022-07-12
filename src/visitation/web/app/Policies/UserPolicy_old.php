<?php

namespace App\Policies;

use App\Models\tb_sys_mf_access_type;
use App\Models\tb_sys_mf_user;
use App\Models\tb_sys_mf_user_access_type;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(tb_sys_mf_user $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\tb_sys_mf_user  $target_user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(tb_sys_mf_user $user, tb_sys_mf_user $target_user)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(tb_sys_mf_user $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\tb_sys_mf_user  $target_user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update($user, $target_user)
    {
        return $user->id == $target_user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\tb_sys_mf_user  $target_user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete($user, tb_sys_mf_user $target_user)
    {
        $full_access = tb_sys_mf_access_type::where('code','FA')->first(); //Get FA/Full Access in Access Type Masterfile
        $user_access = tb_sys_mf_user_access_type::where('user_id', $target_user->id)->where('access_type_id', $full_access->id)->first(); //check if user has full access
        if(isset($user_access)){
            return false;
        }

        return $user->id != $target_user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\tb_sys_mf_user  $target_user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(tb_sys_mf_user $user, tb_sys_mf_user $target_user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\tb_sys_mf_user  $target_user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(tb_sys_mf_user $user, tb_sys_mf_user $target_user)
    {
        //
    }
}
