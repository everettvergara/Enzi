<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\DE_RM_Model;
use Kyslik\ColumnSortable\Sortable;

class tb_crm_tr_sample extends DE_RM_Model
{
    use HasFactory, Sortable;

    protected $table = 'tb_crm_tr_sample';

    // 
    public $columns = [ 
        'id'                  => 'number',
        'sample_date'         => 'date',
        'code'                => 'text',
        'name'                => 'text',
        'remarks'             => 'textarea',
        'status_id'           => 'select'
    ];

    public $sortableAs = ['status_name'];

    protected $validation = [
                            'sample_date' => 'required',
                            'code' => 'required|max:30',
                            'name'  => 'required|max:255',
                            'remarks'    => 'nullable',
                            'status_id' => 'nullable',
                        ];

    protected $labels = ['status_id' => 'STATUS'];
    protected $ddl_list = ['status_id' => ['ddl_model_path' => 'App\Models\tb_sys_mf_status', 'ddl_code' => 'default'],];
    protected $ddl_queries = ['default' => 'select * from tb_crm_tr_sample'];

// Province:
//  tb_crm_mf_province
//  $ddl_queries = ['default' => 'select * from tb_crm_mf_province'];
//
// City:
//  tb_crm_mf_city
//  $ddl_queries = ['default' => 'select * from tb_crm_mf_city', 'conditional' => 'select * from tb_crm_mf_city where province_id = :province_id', , ':province_id' => '0'];
//
//
// 
// Brgy
//  tb_crm_mf_brgy
//  $ddl_queries = ['default' => 'select * from tb_crm_mf_city', 'conditional' => 'select * from tb_crm_mf_city where city_id = :city_id', ':city_id' => '0'];
//
//
// Customer:
// tb_crm_mf_customer
// $ddl_list = ['province_id' =>  ['ddl_model_path' => 'App\Models\tb_crm_mf_province', 'ddl_code' => 'default', 'conditional-dependents' => 'city_id,otherfields,....', 'conditional-subdependents' => 'brgy_id'],
//              'city_id' => ['ddl_model_path' => 'App\Models\tb_crm_mf_city', 'ddl_code' => 'conditional', 'conditional-dependents' => 'brgy_id'],
//              'brgy_id' => ['ddl_model_path' => 'App\Models\tb_crm_mf_province', 'ddl_code' => 'conditional'] ]
//



    protected $rm_select = ['tb_crm_tr_sample.id', 'tb_crm_tr_sample.sample_date', 'tb_crm_tr_sample.code', 'tb_crm_tr_sample.name', 'tb_crm_tr_sample.remarks', 'status.name as status_name'];
    protected $rm_inner_joins = ['tb_sys_mf_status' => ['foreign_table' => 'tb_sys_mf_status as status', 'foreign_id' => 'status.id', 'reference_id' => 'tb_crm_tr_sample.status_id'],];
    
    public $rm_filter_columns = [
                                 'name'         => 'tb_sys_mf_status',
                                 'status_id'    => 'tb_crm_tr_sample', 
                                 'sample_date'  => 'tb_crm_tr_sample',
                                ];
    
    protected $ddl_dynamic = ['status_id' => ['placeholder' => 'Select the Status', 'model_path' => 'App\Models\tb_sys_mf_status'],];

    // date -> filter date from- date to (between)
    // time -> filter datetime_from - datetime_to (between)
    // select -> ddw (=)
    // *select-dynamic 
    // *conditional select
    // *searcher
    // number -> text (=)
    // decimal -> text - range between  
    // else -> text (like)

}