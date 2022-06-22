<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\DE_RM_Model;
use Kyslik\ColumnSortable\Sortable;

class tb_sys_mf_approval_hierarchy_type extends DE_RM_Model
{
    use HasFactory, Sortable;

    protected $table = 'tb_sys_mf_approval_hierarchy_type';

    public $columns = [ 'id' => 'text',
                        'code' => 'text',
                        'name' => 'text',
                        'description'   => 'textarea',
                        'is_active' => 'checkbox',
                    ];
    
    protected $validation = [
        'name'              => 'required|max:255',
        'code'              => 'required|max:30',
        'description'       => 'nullable',
        'is_active'         => 'nullable',
    ];

    protected $ddl_queries = [
        'default'       => 'select * from tb_sys_mf_approval_hierarchy_type',
    ];

    protected $rm_select = ['id', 'code', 'name', 'description', 'is_active'];

    public $rm_filter_columns = [
        'name'         => 'tb_sys_mf_access_type',
    ];

}
