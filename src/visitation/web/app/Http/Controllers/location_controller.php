<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class location_controller extends MF_DE_Controller
{
    protected $model_path = 'App\Models\location';

    protected $title = 'LOCATION';
    protected $route = 'locations';
    protected $route_param = 'location';
    protected $column_num = 3;
}
