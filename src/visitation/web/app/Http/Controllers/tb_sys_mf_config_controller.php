<?php

namespace App\Http\Controllers;

use App\Models\tb_sys_mf_config;

class tb_sys_mf_config_controller extends MF_DE_Controller
{

    protected $model_path = 'App\Models\tb_sys_mf_config';

    protected $title = 'VARIABLES';
    protected $route = 'configs';
    protected $route_param = 'config';
    protected $column_num = 3;
}
