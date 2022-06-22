<?php

namespace App\Http\Controllers;

use App\Http\Requests\tb_sys_mf_mod_validation;
use App\Models\tb_sys_mf_access_type;
use App\Models\tb_sys_mf_approval_hierarchy_type;
use App\Models\tb_sys_mf_mod;
use App\Models\tb_sys_mf_mod_access_type;
use App\Models\tb_sys_mf_mod_approval_hierarchy_type;
use App\Models\tb_sys_mf_mod_group;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class tb_sys_mf_mod_controller extends Controller
{
    public function index(Request $request)
    {
        $name = $request['name'];
        $mods = tb_sys_mf_mod::join('tb_sys_mf_mod_group', 'tb_sys_mf_mod_group.id', 'tb_sys_mf_mod.mod_group_id')
                                ->when(isset($name), function ($q) use ($name){
                                        return $q->where('tb_sys_mf_mod.name', 'like', '%'.$name.'%');})
                                ->select('tb_sys_mf_mod.id', 'tb_sys_mf_mod.name', 'tb_sys_mf_mod.code', 'tb_sys_mf_mod.menu', 
                                        'tb_sys_mf_mod.mod_group_id', 'tb_sys_mf_mod_group.name as mod_group_name')
                                ->sortable(['id', 'code', 'name', 'menu' ,'mod_group_name'])
                                ->paginate(env('ROW_COUNT'));
        return view ('tb_sys_mf_mod.index', [
            'mods' => $mods
        ]);
    }

    public function create()
    {
        $mod_groups_dd = tb_sys_mf_mod_group::all();
        $detail_access_types_dd = tb_sys_mf_access_type::all();
        $detail_apr_type_dd = tb_sys_mf_approval_hierarchy_type::all();
        return view ('tb_sys_mf_mod.create', [
            'mod_groups_dd' => $mod_groups_dd,
            'detail_access_types_dd' => $detail_access_types_dd,
            'detail_apr_type_dd' => $detail_apr_type_dd,
        ]);
    }

    public function store(tb_sys_mf_mod_validation $request)
    {

        if(Route::has($request->url.'.index') == false){
            $request->session()->flash('alert', 'URL not valid!');
            return redirect()->back();
        }

        $validatedData = $request->validated();
        $detail_access_types = ($validatedData['detail_access_type_id']??[]);
        $detail_apr_types = ($validatedData['detail_apr_type_id']??[]);

        $remove = [ 'detail_access_type_id',
                    'detail_mod_access_type_id', 
                    'detail_apr_type_id',
                    'detail_mod_apr_type_id'];

        $validatedData = array_diff_key($validatedData, array_flip($remove));


        $mod = new tb_sys_mf_mod();
        $mod->fill($validatedData);
        $mod->save();
        if(count($detail_access_types)>0){  
            foreach($detail_access_types as $detail_access_type => $i){
                $data2 = array(
                    'mod_id' => $mod->id,
                    'access_type_id' =>  $detail_access_types[$detail_access_type],
                    'created_at' => Carbon::now('UTC'),
                    'updated_at' => Carbon::now('UTC')
                );
                tb_sys_mf_mod_access_type::insert($data2);
            }
        }

        if(count($detail_apr_types)>0){  
            foreach($detail_apr_types as $detail_apr_type => $i){
                $data3 = array(
                    'mod_id' => $mod->id,
                    'approval_type_id' =>  $detail_apr_types[$detail_apr_type],
                    'created_at' => Carbon::now('UTC'),
                    'updated_at' => Carbon::now('UTC')
                );
                tb_sys_mf_mod_approval_hierarchy_type::insert($data3);
            }
        }

        $request->session()->flash('status', 'Module created successfully!');
        return redirect()->route('mods.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $mod = tb_sys_mf_mod::findOrFail($id);
        $mod_groups_dd = tb_sys_mf_mod_group::all();
        $detail_access_types_dd = tb_sys_mf_access_type::all();
        $mod_access_types = tb_sys_mf_mod_access_type::where('mod_id', $id)->get();
        $detail_apr_type_dd = tb_sys_mf_approval_hierarchy_type::all();
        $mod_apr_types = tb_sys_mf_mod_approval_hierarchy_type::where('mod_id', $id)->get();
        return view ('tb_sys_mf_mod.edit', [
            'mod' => $mod,
            'mod_groups_dd' => $mod_groups_dd,
            'detail_access_types_dd' => $detail_access_types_dd,
            'mod_access_types' => $mod_access_types,
            'detail_apr_type_dd' => $detail_apr_type_dd,
            'mod_apr_types' => $mod_apr_types,
        ]);
    }

    public function update(tb_sys_mf_mod_validation $request, $id)
    {
        
        if(Route::has($request->url.'.index') == false){
            $request->session()->flash('alert', 'URL not valid!');
            return redirect()->back();
        }

        $validatedData = $request->validated();

        $mod = tb_sys_mf_mod::findOrFail($id);
        $detail_access_types = ($validatedData['detail_access_type_id']??[]);
        $detail_mod_access_types = ($validatedData['detail_mod_access_type_id']??[]);
        $detail_apr_types = ($validatedData['detail_apr_type_id']??[]);
        $detail_mod_apr_types = ($validatedData['detail_mod_apr_type_id']??[]);
        $remove = [ 'detail_access_type_id',
                    'detail_mod_access_type_id', 
                    'detail_apr_type_id',
                    'detail_mod_apr_type_id'];
        $validatedData = array_diff_key($validatedData, array_flip($remove));
        $mod->fill($validatedData);

        // Delete All Mod Access
        if(count($detail_mod_access_types)==0){     
            $not = DB::table('tb_sys_mf_mod_access_type')
                            ->select('id')
                            ->where('mod_id', $mod->id)
                            ->get();
            foreach($not as $n){
                $remove_data = DB::table('tb_sys_mf_mod_access_type')
                                    ->where('id', $n->id)
                                    ->delete();
            }
        }   else {  // Delete Removed Mod Access
            $not = DB::table('tb_sys_mf_mod_access_type')
                        ->select('id')
                        ->where('mod_id', $mod->id)
                        ->whereNotIn('id', $detail_mod_access_types)
                        ->get();
            foreach($not as $n){
                $remove_data = DB::table('tb_sys_mf_mod_access_type')
                                    ->where('id', $n->id)
                                    ->delete();
            }
        }

        // Delete All Mod Approval
        if(count($detail_mod_apr_types)==0){     
            $not = DB::table('tb_sys_mf_mod_approval_hierarchy_type')
                        ->select('id')
                        ->where('mod_id', $mod->id)
                        ->get();
            foreach($not as $n){
                $remove_data = DB::table('tb_sys_mf_mod_approval_hierarchy_type')
                                    ->where('id', $n->id)
                                    ->delete();
            }
        }   else {  // Delete Removed Mod Approval
            $not = DB::table('tb_sys_mf_mod_approval_hierarchy_type')
                        ->select('id')
                        ->where('mod_id', $mod->id)
                        ->whereNotIn('id', $detail_mod_apr_types)
                        ->get();
            foreach($not as $n){
                $remove_data = DB::table('tb_sys_mf_mod_approval_hierarchy_type')
                                    ->where('id', $n->id)
                                    ->delete();
            }
        }
        // Update/Create Access Type
        if(count($detail_access_types)>0){
            foreach($detail_access_types as $key => $detail_access_type){
                if(isset($detail_mod_access_types[$key])){
                    $update = DB::table('tb_sys_mf_mod_access_type')->where('id', $detail_mod_access_types[$key])->update(
                        [
                            'access_type_id' =>  $detail_access_types[$key],
                            'updated_at' => Carbon::now('UTC')
                        ]
                    );
                }
                else{
                    $create = DB::table('tb_sys_mf_mod_access_type')->insert([
                        'mod_id' => $mod->id,
                        'access_type_id' =>  $detail_access_types[$key],
                        'created_at' => Carbon::now('UTC'),
                        'updated_at' => Carbon::now('UTC')
                    ]);   
                }
            }
        }
        // Update/Create Approval Type
        if(count($detail_apr_types)>0){
            foreach($detail_apr_types as $key => $detail_apr_type){
                if(isset($detail_mod_apr_types[$key])){
                    $update = DB::table('tb_sys_mf_mod_approval_hierarchy_type')->where('id', $detail_mod_apr_types[$key])->update(
                        [
                            'approval_type_id' =>  $detail_apr_types[$key],
                            'updated_at' => Carbon::now('UTC')
                        ]
                    );
                }
                else{
                    $create = DB::table('tb_sys_mf_mod_approval_hierarchy_type')->insert([
                        'mod_id' => $mod->id,
                        'approval_type_id' =>  $detail_apr_types[$key],
                        'created_at' => Carbon::now('UTC'),
                        'updated_at' => Carbon::now('UTC')
                    ]);   
                }
            }
        }
        $mod->update();
        $request->session()->flash('status', 'Mod updated successfully!');
        return redirect()->route('mods.index');
    }

    public function destroy(Request $request, $id)
    {
        $mod = tb_sys_mf_mod::findOrFail($id);
        $mod->delete();
        $request->session()->flash('status', 'Mod was deleted!');
        return redirect()->route('mods.index');
    }

    public function select_mod(Request $request)
    {
    	$search = $request->search;
        if($search == ''){
            $results = tb_sys_mf_mod::select('id', 'name')
            ->orderBy('name', 'asc')
            ->limit(5)
            ->get();
        }else{
            $results = tb_sys_mf_mod::select('id', 'name')
            ->where('name', 'like', '%'.$search.'%')
            ->orderBy('name', 'asc')
            ->get();
        }
        $response = array();
        foreach($results as $result){
            $response[] = array(
                "id" => $result->id,
                "text" => $result->name,
            );
        }
        echo json_encode($response);
    }
}
