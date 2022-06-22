<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\DE_RM_Model;
use Kyslik\ColumnSortable\Sortable;

class country extends DE_RM_Model
{
    use HasFactory, Sortable;

    protected $table = 'countries';

    public $columns = [ 
        'id'                  => 'number',
        'name'                => 'text',
    ];

    protected $validation = [
        'name'  => 'required|max:255',
    ];

    protected $ddl_queries = ['default' => 'select * from countries'];

    protected $rm_select = ['id', 'name'];

    public $rm_filter_columns = [
        'name'         => 'countries',
    ];

}
