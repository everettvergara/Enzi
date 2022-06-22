<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class country_controller extends MF_DE_Controller
{
    protected $model_path = 'App\Models\country';

    protected $title = 'COUNTRY';
    protected $route = 'countries';
    protected $route_param = 'country';
    protected $column_num = 3;
}
