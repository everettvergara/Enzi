<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\DE_RM_Model;
use Kyslik\ColumnSortable\Sortable;

class city extends DE_RM_Model
{
    use HasFactory, Sortable;

    protected $table = 'cities';

    public $columns = [ 
        'id'                  => 'number',
        'country_id'          => 'select',
        'region_id'           => 'select-dynamic',
        'name'                => 'text',
    ];

    protected $labels = [
        'country_id'    => 'COUNTRY',
        'region_id'     => 'REGION',
    ];

    protected $validation = [
        'name'          => 'required|max:255',
        'country_id'    => 'required',
        'region_id'     => 'required',
    ];

    public $sortableAs = ['country_name' , 'region_name'];

    protected $ddl_list = [
        'country_id'    => ['ddl_model_path' => 'App\Models\country', 'ddl_code' => 'default', 'conditional-dependents' => ['region_id' => ['dependent-parameters' => [':country_id' => 'country_id']],],],
        'region_id'     => ['ddl_model_path' => 'App\Models\region',    'ddl_code' => 'conditional-country-id'],             
    ];

    protected $ddl_conditional = [
        'region_id'     => ['columns' => ['country_id'], 'model_path' => 'App\Models\region'],
    ];

    protected $ddl_queries = [
        'default'       => 'select * from cities',
        'conditional-region-id'   => ['query' => 'select * from cities where region_id = :region_id', 'default' => [':region_id' => 0]],
        'conditional-date'  => ['query' => 'select * from cities where created_at between :date_from and :date_to', 'default' => [':date_from' => '2022-01-01', ':date_to' => '2022-01-01']],
    ];

    protected $rm_select = ['cities.id', 'countries.name as country_name', 'regions.name as region_name', 'cities.name'];

    protected $rm_inner_joins = [
        'countries'     => ['foreign_table' => 'countries', 'foreign_id' => 'countries.id', 'reference_id' => 'cities.country_id'],
        'regions'       => ['foreign_table' => 'regions', 'foreign_id' => 'regions.id', 'reference_id' => 'cities.region_id'],
    ];

    public $rm_filter_columns = [
        'name'              => 'cities',
        'country_id'        => 'cities',
        'region_id'         => 'cities',
    ];


}