<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Kyslik\ColumnSortable\Sortable;
use Carbon\Carbon;

class DE_RM_Model extends Model
{
    use HasFactory, Sortable;
    
    // Model defined protected vars
    public $sortable = [];
    public $sortableAs = [];
    protected $fillable = []; 

    // Column and the Input Type (text, textarea, select)
    // $columns['code' => 'type,label,alternative_name']
    protected $columns = [];
    protected $labels = [];
    protected $ddl_list = [];

    protected $validation = [];

    // Dropdown List Columns and coresponding select queries
    protected $ddl = [];
    
    // The query of this model when used as a dropdown
    // $ddl_queries['default' => 'select id, name from tb_crm_mf_address']
    protected $ddl_queries = [];

    protected $ddl_dynamic = [];

    protected $ddl_conditional = [];

    protected $searchers = [];
    protected $searchers_ddl_list = [];

    protected $rm_select = [];
    protected $rm_inner_joins = [];
    protected $rm_left_joins = [];
    protected $rm_right_joins = [];

    //protected $rm_cross_joins = ['tb_sys_mf_mod' => ['foreign_table' => 'tb_sys_mf_mod as mod'],];
    protected $rm_cross_joins = [];
    
    protected $rm_filter_column = [];

    public function __construct()
    {
        parent::__construct();
        $this->set_sortable();
    }
    
    public function validation(){
        return $this->validation;
    }

    public function get_rm_select()
    {
        return $this->rm_select;
    }

    public function get_rm_inner_joins()
    {
        return $this->rm_inner_joins;
    }

    public function get_rm_left_joins()
    {
        return $this->rm_left_joins;
    }

    public function get_rm_right_joins()
    {
        return $this->rm_right_joins;
    }

    public function get_rm_cross_joins()
    {
        return $this->rm_cross_joins;
    }

    public function get_rm_filter_columns()
    {
        return $this->rm_filter_columns;
    }

    public function init_de()
    {
        $this->set_fillable();
        $this->add_ddl();
    }

    public function init_rm()
    {
        $this->set_sortable();
    }

    public function set_fillable()
    {
        $fields = [];
        foreach($this->columns as $key => $column){
            array_push($fields, $key);
        }
        $this->fillable = $fields;
    }

    public function set_sortable()
    {
        $fields = [];
        foreach($this->columns as $key => $column){
            array_push($fields, $key);
        }
        $this->sortable = $fields;    
    }

    public function get_table()
    {
        return $this->table;
    }

    public function get_columns()
    {
        return $this->columns;
    }

    public function get_labels()
    {
        return $this->labels;
    }

    public function get_sortable()
    {
        return $this->sortable;
    }

    public function get_ddl()
    {
        return $this->ddl;
    }

    public function get_ddl_dynamic(){
        return $this->ddl_dynamic;
    }

    public function get_ddl_conditional(){
        $ddl_conditional = [];
        $ddl_list = $this->ddl_list;

        foreach($ddl_list as $key => $ddl){
            if(isset($ddl['conditional-dependents'])){
                foreach ($ddl['conditional-dependents'] as $conditional_key => $temp_ddl_condtional){
                    $temp_ddl = $ddl_list[$conditional_key];
                    $ddl_conditional[$conditional_key] = ['column' => $key, 'model_path' => $temp_ddl['ddl_model_path'], 'ddl_code' => $temp_ddl['ddl_code'], 'dependent-parameters' => $temp_ddl_condtional['dependent-parameters'], 'subdependents' => $ddl['subdependents']??[]];
                }
            }
        }
        $this->ddl_conditional = $ddl_conditional;
        return $this->ddl_conditional;
    }

    public function get_searchers(){
        return $this->searchers;
    }

    public function get_searcher_ddl_list(){
        return $this->searchers_ddl_list;
    }
    
    public function get_ddl_query($code = 'default') 
    {
        return $this->ddl_queries[$code];
    }

    public function add_ddl()
    {
        $ddl = array();
        foreach($this->ddl_list as $key => $list) {
                $model = new ($list['ddl_model_path']);
                $ddl[$key] = ['ddl_query'=> $model->get_ddl_query($list['ddl_code']??'default'), 'ddl_model' => $list['ddl_model_path']];
        }
       // dd($ddl);
        $this->ddl = $ddl;
    }
    
}