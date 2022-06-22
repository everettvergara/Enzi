<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TR_DE_Controller extends DE_Controller
{
    public function create()
    {
        $model = new ($this->model_path);
        $fields = $this->get_model_columns($model);
        $labels = $this->get_model_labels($model);
        $ddl = $this->get_model_ddl($model);
        $ddl_dynamic = $this->get_model_ddl_dynamic($model);
        $ddl_conditional = $this->get_model_ddl_conditional($model);
        $searchers = $this->get_model_searchers($model);
        $searcher_ddl = $this->get_model_searcher_ddl($model);
        $searcher_conditional = $this->get_model_searcher_conditional($model);
        
        return view ('general.tr_create',[
            'title'             => $this->title,
            'route'             => $this->route,
            'fields'            => $fields,
            'labels'            => $labels,
            'ddl'               => $ddl,
            'ddl_dynamic'       => $ddl_dynamic,
            'ddl_conditional'   => $ddl_conditional,
            'searchers'         => $searchers,
            'searcher_ddl'      => $searcher_ddl,
            'searcher_conditional' => $searcher_conditional,
            'column_num'        => $this->set_column_number($this->column_num),
        ]);
    }

    public function store(Request $request)
    { 
        $model = new $this->model_path();
        $validation = $model->validation();
        $validatedData = $request->validate($validation);
        switch ($request['status']) {
            case 'save':
                $validatedData['status_id'] = 1;
                break;
            case 'post':
                $validatedData['status_id'] = 2;
                break;
            default:
                throw ValidationException::withMessages(['status' => 'Status not supported']);
                break;
        }

        $model->init_de();
        $model->fill($validatedData);
        $model->save();
        $request->session()->flash('status', ucfirst(strtolower($this->title)).' created successfully!');
        return redirect()->route($this->route.'.show', [$this->route_param => $model->id]);
    }

    public function show($id)
    {
        $element = $this->model_path::findOrFail($id);
        $model = new ($this->model_path);
        $fields = $this->get_model_columns($model);
        $ddl = $this->get_model_ddl($model);
        $disabled = 1;

        return view ('general.show',[
            'element' => $element,
            'disabled'  => $disabled,
            'title' => $this->title,
            'route' => $this->route,
            'route_param' => $this->route_param,
            'fields'   => $fields,
            'ddl'   => $ddl,
            'column_num'    => $this->set_column_number($this->column_num),
        ]);
    }

    public function edit($id)
    {
        $element = $this->model_path::findOrFail($id);
        $trans_status = $element->status_id;
        if ($trans_status == 1){
            $disabled = "0";
        }else{
            $disabled = "1";
        }
        $model = new ($this->model_path);
        $fields = $this->get_model_columns($model);
        $ddl = $this->get_model_ddl($model);
        $ddl_dynamic = $this->get_model_ddl_dynamic($model);
        $ddl_conditional = $this->get_model_ddl_conditional($model);
        $searchers = $this->get_model_searchers($model);
        $searcher_ddl = $this->get_model_searcher_ddl($model);
        
        $searcher_conditional = $this->get_model_searcher_conditional($model);

        return view ('general.tr_edit', [
            'element'           => $element,
            'disabled'          => $disabled,
            'title'             => $this->title,
            'route'             => $this->route,
            'route_param'       => $this->route_param,
            'fields'            => $fields,
            'ddl'               => $ddl,
            'ddl_dynamic'       => $ddl_dynamic,
            'ddl_conditional'   => $ddl_conditional,
            'searchers'         => $searchers,
            'searcher_ddl'      => $searcher_ddl,
            'searcher_conditional' => $searcher_conditional,
            'column_num'        => $this->set_column_number($this->column_num),
        ]);
    }

    public function update(Request $request, $id)
    {
        $model = $this->model_path::findOrFail($id);
        $validation = $model->validation();
        $validatedData = $request->validate($validation);
        switch ($request['status']) {
            case 'save':
                $validatedData['status_id'] = 1;
                break;
            case 'post':
                $validatedData['status_id'] = 2;
                break;
            case 'cancel':
                $validatedData['status_id'] = 3;
                break;
            default:
                throw ValidationException::withMessages(['status' => 'Status not supported']);
                break;
        }
        $model->init_de();
        $model->fill($validatedData);
        $model->update();
        $request->session()->flash('status', ucfirst(strtolower($this->title)).'  updated successfully!');
        return redirect()->back();
    }

    public function destroy(Request $request, $id)
    {
        $model = $this->model_path::findOrFail($id);
        $model->delete();
        $request->session()->flash('status', ucfirst(strtolower($this->title)).' was deleted!');
        return redirect()->back();
    }
}
