<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;

class tb_sys_mf_config extends DE_RM_Model
{
    use HasFactory, Sortable;

    protected $table = 'tb_sys_mf_config';

    public $columns = [ 'id' => 'text',
                        'code' => 'text',
                        'name' => 'text',
                        'value' => 'textarea',
                        'description'   => 'textarea',
                        'is_active' => 'checkbox',
                    ];

    protected $validation = [
        'name'              => 'required|max:255',
        'code'              => 'required|max:30',
        'value'             => 'required',
        'description'       => 'nullable',
        'is_active'         => 'nullable',
    ];

    protected $ddl_queries = [
        'default'       => 'select * from tb_sys_mf_config',
    ];

    protected $rm_select = ['id', 'code', 'name', 'value', 'description', 'is_active'];

    public $rm_filter_columns = [
        'name'         => 'tb_sys_mf_config',
    ];

}
