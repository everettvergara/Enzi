<?php

namespace App\Providers;

use App\Models\tb_sys_mf_user;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class NavigationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    // lev = 2
    // instructions[] = "ul li (main) /li ul li (master) /li li (trans) /li /ul li
    // stacks[ul] = "ul li
    // if db_level > lev push (ul) (li); {li must have sub menu item - group}
    // if same level = :if  peek == li then close last item (pop); push li {li does not have sub menu item - mod}
    // if curr level < {if last pop == ul --currlvel} {same as above}
    // 

    public function boot()
    {
        view()->composer('*', function ($view) {

            $lev = 0;
            $stack = array();
            $instructions = array();
            $pop = array();

            $auth_user = null;

            if (Auth::check()) {
                $auth_user = tb_sys_mf_user::findOrFail(Auth::id());
                
                if(env('DB_CONNECTION') == "sqlsrv"){
                    $results = DB::select('exec sp_call_mod_user_access @user_id = ?', array($auth_user->id));
                }
                else{
                    $results = DB::select('call sp_call_mod_user_access(?)', array($auth_user->id));
                }


                foreach($results as $result) {
                
                    if ($result->level > $lev){
                        if(!empty($instructions)){
                            $pop = array_pop($instructions);
                            $pop['class'] = 'sub';
                            array_push($instructions, $pop);
                        }
                        array_push($stack, ['ul']);
                        array_push($stack, ['li']);
                        if (empty($instructions))
                            array_push($instructions, ['dom'=>'ul', 'class'=>'first']);
                        else
                            array_push($instructions, ['dom'=>'ul']);
                        array_push($instructions, ['dom'=>'li', 'menu_name' => ($result->mod_id > 0 ? $result->mod_name : $result->mod_group_name), 'mod_id' =>$result->mod_id, 'url' => $result->url]);
                        ++$lev;

                    } else if ($result->level == $lev) {
                        $pop = array_pop($stack); 
                        array_push($instructions, ['dom'=>'/li']);
                        array_push($stack, ['li']);
                        array_push($instructions, ['dom'=>'li', 'menu_name' => ($result->mod_id > 0 ? $result->mod_name : $result->mod_group_name), 'mod_id' =>$result->mod_id, 'url' => $result->url]);
                    
                    } else {
                        while ($result->level < $lev) {
                            $pop = array_pop($stack);
                            if($pop['0'] == "ul") {
                                array_push($instructions, ['dom'=>'/ul']);
                                --$lev;
                            } else {
                                array_push($instructions, ['dom'=>'/li']);
                            }
                        }
                        array_pop($stack);
                        array_push($instructions, ['dom'=>'/li']);
                        array_push($stack, ['li']);
                        array_push($instructions, ['dom'=>'li', 'menu_name' => ($result->mod_id > 0 ? $result->mod_name : $result->mod_group_name), 'mod_id' =>$result->mod_id, 'url' => $result->url]);
                    }
                }
                while ($lev != 0){
                    $pop = array_pop($stack);
                    array_push($instructions, ['dom'=>'/'.$pop['0']]);
                    if($pop['0'] == "ul")
                        --$lev;
                }
            }   
            return $view->with('instructions', $instructions)->with('auth_user', $auth_user);
        });
        
            
           

    }
}


