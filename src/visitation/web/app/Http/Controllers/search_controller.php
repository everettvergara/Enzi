<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class search_controller extends Controller
{
    public function index(Request $request){
        $column_name = $request->column;
        $model_path = $request->model_path;
        $ddl_code = $request->ddl_code;
        $filters = json_decode($request->filters, true);
        $tmp_values = json_decode($request->values, true);
        $columns = json_decode($request->columns, true);
        $values = [];
        $results = [];
        foreach($filters as $key => $filter){
            foreach($tmp_values as $key_2 => $tmp_value){
                switch (true) {
                    case $filter['input'] == 'date':
                        if(strstr($filter['column'], '_to')){
                            if($column_name.'_modal_'.$filter['column'] == $tmp_value['name']){
                                $values[$key] = Carbon::createFromFormat('Y-m-d', $tmp_value['value'])->endOfDay()->toDateTimeString();
                            }
                        }
                        else{
                            if($column_name.'_modal_'.$filter['column'] == $tmp_value['name']){
                                $values[$key] = $tmp_value['value'];
                            }
                        }
                        break;
                    default:
                        if($column_name.'_modal_'.$filter['column'] == $tmp_value['name']){
                            $values[$key] = $tmp_value['value'];
                        }
                        break;
                }
            }
        }
        $model = new ($model_path);
        $query = $model->get_ddl_query($ddl_code);
        if(is_array($query)){
            $defaults = $query['default'];
            foreach ($defaults as $key => $default){
                if(isset($values[$key]))
                {
                    $defaults[$key] = $values[$key];
                }
            }
            $results = DB::select(DB::raw($query['query']), $defaults);
        }
        else{
            $results = DB::select(DB::raw($query));
        }
        $view = view ('components.searcher-table', [
            'key'   => $column_name,
            'elements' => json_decode(json_encode($results), true),
            'columns' => $columns
        ]);
        return $view;
    }
}
