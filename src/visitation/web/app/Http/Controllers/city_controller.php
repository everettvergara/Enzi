<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class city_controller extends MF_DE_Controller
{
    protected $model_path = 'App\Models\city';

    protected $title = 'CITY';
    protected $route = 'cities';
    protected $route_param = 'city';
    protected $column_num = 3;
}
