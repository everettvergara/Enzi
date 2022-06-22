<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\DE_RM_Model;
use Kyslik\ColumnSortable\Sortable;

class location extends DE_RM_Model
{
    use HasFactory, Sortable;

    protected $table = 'locations';

    // [text, number, textarea, select, select-dynamic, searcher, date, checkbox]
    public $columns = [ 
        'id'                  => 'number',
        'country_id'          => 'select',
        'region_id'           => 'select',
        'city_id'             => 'searcher',
        'name'                => 'text',
    ];

    public $sortableAs = ['country_name' , 'region_name'];

    protected $validation = [
        'name'          => 'required|max:255',
        'country_id'    => 'required',
        'region_id'     => 'required',
        'city_id'       => 'required',
    ];

    protected $labels = [
        'country_id'    => 'COUNTRY',
        'region_id'     => 'REGION',
        'city_id'       => 'CITY',
    ];

    protected $ddl_list = [
        'country_id'    => ['ddl_model_path' => 'App\Models\country',   'ddl_code' => 'default', 'conditional-dependents' => ['region_id' => ['dependent-parameters' => [':country_id' => 'country_id']]],
                                                                                                'subdependents' => ['city_id'],
                                                                                                ],
        'region_id'     => ['ddl_model_path' => 'App\Models\region',    'ddl_code' => 'conditional-country-id', 'conditional-dependents' => ['city_id' => ['dependent-parameters' => [':region_id' => 'region_id']]]],
        'city_id'       => ['ddl_model_path' => 'App\Models\city',      'ddl_code' => 'default'],
    ];

    // protected $ddl_list = [
    //     'country_id'    => ['ddl_model_path' => 'App\Models\country',   'ddl_code' => 'default', 'conditional-dependents' => [
    //                                                                                                                             'region_id' => ['dependent-parameters' => [':country_id' => 'country_id']],
    //                                                                                                                             'region2_id' => ['dependent-parameters' => [':country_id' => 'country_id',':value' => '1']]
    //                                                                                                                         ],
    //                                                                                             'subdependents' => ['city_id', 'city2_id'],
    //                                                                                             ],
    //     'region_id'     => ['ddl_model_path' => 'App\Models\region',    'ddl_code' => 'conditional-country-id', 'conditional-dependents' => ['city_id' => ['dependent-parameters' => [':region_id' => 'region_id']]]],
    //     'city_id'       => ['ddl_model_path' => 'App\Models\city',      'ddl_code' => 'conditional-region-id'], 
    // ];

    protected $searchers = [
        'city_id' => [
            'searcher_model_path'   => 'App\Models\city',
            'searcher_code'         => 'conditional-region-id',
            'searcher_columns'      => ['id', 'name'],
            'searcher_filters'      => [':country_id' => ['column' => 'country_id', 'input' => 'select'],
                                        ':region_id'  => ['column' => 'region_id', 'input' => 'select-dynamic']
                                    ],
        ]
    ];

    protected $searchers_ddl_list = [
        'city_id'   => [
            'country_id'   => ['ddl_model_path' => 'App\Models\country', 'ddl_code' => 'default', 'conditional-dependents' => ['region_id' => ['dependent-parameters' => [':country_id' => 'country_id']]]],
            'region_id' => ['ddl_model_path' => 'App\Models\region', 'ddl_code' => 'conditional-country-id']
        ]
    ];

    // protected $searchers = [
    //     'city_id' => [
    //         'searcher_model_path'   => 'App\Models\city',
    //         'searcher_code'         => 'conditional-date',
    //         'searcher_columns'      => ['id', 'name', 'created_at'],
    //         'searcher_filters'      => [':date_from' => ['column' => 'date_from', 'input' => 'date'],
    //                                     ':date_to' => ['column' => 'date_to', 'input' => 'date']],
    //     ]
    // ];

    // protected $searchers = [
    //     'city_id' => [
    //         'searcher_model_path'   => 'App\Models\city',
    //         'searcher_code'         => 'conditional-region-id',
    //         'searcher_columns'      => ['id', 'name'],
    //         'searcher_filters'      => [':region_id' => ['column' => 'region_id', 'input' => 'select']],
    //     ]
    // ];

    // protected $searchers_ddl_list = [
    //     'city_id'   => [
    //         'region_id' => ['ddl_model_path' => 'App\Models\region', 'ddl_code' => 'default']
    //     ]
    // ];

    protected $ddl_queries = [
        'default'               => 'select * from locations',
        'conditional-city-id'   => ['query' => 'select * from locations where city_id = :city_id', 'default' => [':city_id' => 0]],
    ];

    protected $rm_select = ['locations.id', 'countries.name as country_name', 'regions.name as region_name', 'cities.name as city_name', 'locations.name'];

    protected $rm_inner_joins = [
        'countries'     => ['foreign_table' => 'countries', 'foreign_id' => 'countries.id', 'reference_id' => 'locations.country_id'],
        'regions'       => ['foreign_table' => 'regions',   'foreign_id' => 'regions.id', 'reference_id' => 'locations.region_id'],
        'cities'        => ['foreign_table' => 'cities',    'foreign_id' => 'cities.id', 'reference_id' => 'locations.city_id'],
    ];

    public $rm_filter_columns = [
        'name'              => 'locations',
        'country_id'        => 'locations',
        'region_id'         => 'locations',
        'city_id'           => 'locations',
    ];
}
