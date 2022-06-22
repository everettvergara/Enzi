<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class dynamic_select_controller extends Controller
{
    public function index(Request $request)
    {
        // Log::debug($request);
        // die();
        $model = new ($request->model_path);
        $search = $request->search;

        if($search == '')
        {
            $results = $model::select('id', 'name')
            ->orderBy('name', 'asc')
            ->limit(5)
            ->get();
        }
        
        else
        {
            $results = $model::select('id', 'name')
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