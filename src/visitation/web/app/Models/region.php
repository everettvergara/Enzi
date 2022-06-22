<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\DE_RM_Model;
use Kyslik\ColumnSortable\Sortable;

class region extends DE_RM_Model
{
    use HasFactory, Sortable;

    protected $table = 'regions';

    public $columns = [ 
        'id'                  => 'number',
        'country_id'          => 'select',
        'name'                => 'text',
    ];

    public $sortableAs = ['country_name'];

    protected $validation = [
        'name'          => 'required|max:255',
        'country_id'    => 'required',
    ];

    protected $labels = ['country_id' => 'COUNTRY'];

    protected $ddl_list = ['country_id' => ['ddl_model_path' => 'App\Models\country', 'ddl_code' => 'default'],];

    protected $ddl_queries = [
        'default'                   => 'select * from regions',
        'conditional-country-id'   => ['query' => 'select * from regions where country_id = :country_id and  1 = :value', 'default' => [':country_id' => 0, ':value' => 1]],
    ];

    protected $rm_select = ['regions.id', 'countries.name as country_name','regions.name'];
    protected $rm_inner_joins = ['countries' => ['foreign_table' => 'countries', 'foreign_id' => 'countries.id', 'reference_id' => 'regions.country_id'],];

    public $rm_filter_columns = [
        'name'         => 'regions',
        'country_id'   => 'regions'
    ];

}
