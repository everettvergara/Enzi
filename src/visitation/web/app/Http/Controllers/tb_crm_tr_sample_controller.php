<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Log;

class tb_crm_tr_sample_controller extends TR_DE_Controller
{
    protected $model_path = 'App\Models\tb_crm_tr_sample';

    protected $title = 'SAMPLES';
    protected $route = 'samples';
    protected $route_param = 'sample';
    protected $column_num = 4;

    // public function select_patient(Request $request)
    // {
    // 	$search = $request->search;
    //     if($search == ''){
    //         $patients = tb_crm_mf_patient::select('id', 'name')
    //         ->orderBy('name', 'asc')
    //         ->limit(5)
    //         ->get();
    //     }else{
    //         $patients = tb_crm_mf_patient::select('id', 'name')
    //         ->where('name', 'like', '%'.$search.'%')
    //         ->orderBy('name', 'asc')
    //         ->get();
    //     }
    //     $response = array();
    //     foreach($patients as $patient){
    //         $response[] = array(
    //             "id" => $patient->id,
    //             "text" => $patient->name,
    //         );
    //     }
    //     echo json_encode($response);
    // }

}