<?php

namespace App\Http\Controllers;

use App\Http\Requests\tb_sys_mf_mod_group_validation;
use App\Models\tb_sys_mf_mod_group;
use Illuminate\Http\Request;

class tb_sys_mf_mod_group_controller extends Controller
{

    public function index(Request $request)
    {
        $name = $request['name'];
        $mod_groups = tb_sys_mf_mod_group::leftJoin('tb_sys_mf_mod_group as a', 'a.id', 'tb_sys_mf_mod_group.ref_mod_id')
                                            ->when(isset($name), function ($q) use ($name){
                                                return $q->where('tb_sys_mf_mod_group.name', 'like', '%'.$name.'%');})
                                            ->select('tb_sys_mf_mod_group.id', 'tb_sys_mf_mod_group.code', 'tb_sys_mf_mod_group.name', 
                                                    'tb_sys_mf_mod_group.menu', 'tb_sys_mf_mod_group.ref_mod_id', 'a.name as ref_mod_name', 'tb_sys_mf_mod_group.seq')
                                            ->sortable()
                                            ->paginate(env('ROW_COUNT'));
        
        return view ('tb_sys_mf_mod_group.index', [
            'mod_groups' => $mod_groups
        ]);
    }

    public function create()
    {
        $mod_groups_dd = tb_sys_mf_mod_group::all();
        return view ('tb_sys_mf_mod_group.create',[
            'mod_groups_dd' => $mod_groups_dd
        ]);
    }

    public function store(tb_sys_mf_mod_group_validation $request)
    {
        $validatedData = $request->validated();
        $mod_group = new tb_sys_mf_mod_group();
        $mod_group->fill($validatedData);
        $mod_group->save();
        $request->session()->flash('status', 'Module group created successfully!');
        // return redirect()->route('uom.show', ['uom' => $uom->id]);
        return redirect()->route('mod-groups.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $mod_groups_dd = tb_sys_mf_mod_group::all();
        $mod_group = tb_sys_mf_mod_group::findOrFail($id);
        return view ('tb_sys_mf_mod_group.edit',[
            'mod_groups_dd' => $mod_groups_dd,
            'mod_group' => $mod_group
        ]);
    }

    public function update(tb_sys_mf_mod_group_validation $request, $id)
    {
        $validatedData = $request->validated();
        $mod_group = tb_sys_mf_mod_group::findOrFail($id);
        $mod_group->fill($validatedData);
        $mod_group->update();
        $request->session()->flash('status', 'Module group updated successfully!');
        // return redirect()->route('uom.show', ['uom' => $uom->id]);
        return redirect()->route('mod-groups.index');
    }

    public function destroy(Request $request, $id)
    {
        $mod_group = tb_sys_mf_mod_group::findOrFail($id);
        $mod_group->delete();
        $request->session()->flash('status', 'Mod Group was deleted!');
        return redirect()->route('mod-groups.index');
    }

    public function select_mod_group(Request $request)
    {
    	$search = $request->search;
        if($search == ''){
            $results = tb_sys_mf_mod_group::select('id', 'name')
            ->orderBy('name', 'asc')
            ->limit(5)
            ->get();
        }else{
            $results = tb_sys_mf_mod_group::select('id', 'name')
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