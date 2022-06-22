<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class region_controller extends MF_DE_Controller
{
    protected $model_path = 'App\Models\region';

    protected $title = 'REGION';
    protected $route = 'regions';
    protected $route_param = 'region';
    protected $column_num = 3;
}
