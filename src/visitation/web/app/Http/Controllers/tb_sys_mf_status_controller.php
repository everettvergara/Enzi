<?php

namespace App\Http\Controllers;

class tb_sys_mf_status_controller extends MF_DE_Controller
{

    protected $model_path = 'App\Models\tb_sys_mf_status';

    protected $title = 'STATUS TYPE';
    protected $route = 'statuses';
    protected $route_param = 'status';
    protected $column_num = 3;

}
