<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class conditional_select_controller extends Controller
{
    public function index(Request $request)
    {
        
        $column = $request->column;
        $tmp_values = json_decode($request->values, true);
        $values = [];
        $model_path = $request->model_path;
        $ddl_code = $request->ddl_code;

        $results = [];

        foreach($tmp_values as $key => $tmp_value){
            $values[$tmp_value['key']] = $tmp_value['value'];
        }

        $model = new ($model_path);
        $query = $model->get_ddl_query($ddl_code);

        if(is_array($query))
        {
            $defaults = $query['default'];
            foreach ($defaults as $key => $default)
            {
                if(isset($values[$key]))
                {
                    $defaults[$key] = $values[$key];
                }
            }
            $results[$column] = DB::select(DB::raw($query['query']), $defaults);
        }
        else
        {
            $results[$column] = DB::select(DB::raw($query));
        }
        
        return response()->json([
            'results' => $results
        ]);
    }
}