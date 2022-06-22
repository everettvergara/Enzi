<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class DE_Controller extends Controller
{
    protected $model_path = '';

    protected $title = '';
    protected $route = '';
    protected $route_param = '';
    protected $column_num = 3;

    public function get_model_fields($model_path){
        $model = new ($model_path);
        return $model->get_sortable();
    }

    public function get_model_sortable($model_path){
        $model = new ($model_path);
        return $model->get_sortable();
    }

    public function get_model_columns($model_path){
        $model = new ($model_path);
        return $model->get_columns();
    }

    public function get_model_labels($model_path){
        $model = new ($model_path);
        return $model->get_labels();
    }

    public function get_model_rm_select($model_path){
        $model = new ($model_path);
        return $model->get_rm_select();
    }

    public function get_model_rm_inner_joins($model_path){
        $model = new ($model_path);
        return $model->get_rm_inner_joins();
    }

    public function get_model_rm_left_joins($model_path){
        $model = new ($model_path);
        return $model->get_rm_left_joins();
    }

    public function get_model_rm_right_joins($model_path){
        $model = new ($model_path);
        return $model->get_rm_right_joins();
    }

    public function get_model_rm_cross_joins($model_path){
        $model = new ($model_path);
        return $model->get_rm_cross_joins();
    }

    public function get_model_rm_filter_columns($model_path){
        $model = new ($model_path);
        return $model->get_rm_filter_columns();
    }

    public function get_model_ddl($model_path, $old_result = null){
        $model = new ($model_path);
        $model->init_de();
        $ddl_lists = $model->get_ddl();
        $ddl = array();

        if(count($ddl_lists)>0){
            foreach($ddl_lists as $key => $ddl_list){
                $ddl_query = $ddl_list['ddl_query'];
                if(is_array($ddl_query)){
                    if($old_result!=null){
                        $model = new $ddl_list['ddl_model'];
                        $model_table = $model->get_table();
                        $old_query = DB::select('select * from '.$model_table.' where id = ' .$old_result[$key]);
                        $query_output = DB::select(DB::raw($ddl_query['query']), $ddl_query['default']);
                        
                        $ddl[$key] = array_unique(array_merge($query_output,$old_query));
                    }
                    else {
                        $query_output = DB::select(DB::raw($ddl_query['query']), $ddl_query['default']);
                        $ddl[$key] = $query_output;
                    }
                    
                }
                else {
                    $query_output = DB::select($ddl_query);
                    $ddl[$key] = $query_output;
                }
            }
        }
        return $ddl;
    }

    public function get_model_ddl_dynamic($model_path){
        $model = new ($model_path);
        return $model->get_ddl_dynamic();
    }

    public function get_model_ddl_conditional($model_path){
        $model = new ($model_path);
        return $model->get_ddl_conditional();
    }

    public function get_model_searchers($model_path){
        $model = new ($model_path);
        $searchers = [];

        if(count($model->get_searchers())>0)
        {
            $searchers = $model->get_searchers();
        }
        return $searchers;
    }

    public function get_model_searcher_ddl($model_path){
        $model = new ($model_path);
        $searcher_ddl_list = $model->get_searcher_ddl_list();
        $searcher_ddl = [];
        if(count($searcher_ddl_list) > 0){
            foreach($searcher_ddl_list as $key => $ddl_lists){
                foreach($ddl_lists as $key_2 => $ddl_list){
                    $ddl_model = new ($ddl_list['ddl_model_path']);
                    $ddl_query = $ddl_model->get_ddl_query($ddl_list['ddl_code']);

                    if(is_array($ddl_query)){
                        $defaults = $ddl_query['default'];
                        $results = DB::select(DB::raw($ddl_query['query']), $defaults);
                    } 
                    else {
                        $results = DB::select(DB::raw($ddl_query));
                    }
                    $searcher_ddl[$key.'_modal_'.$key_2] = $results;
                }
            }
        }
        return $searcher_ddl;
    }

    public function get_model_searcher_conditional($model_path){
        $model = new ($model_path);
        $searcher_ddl_list = $model->get_searcher_ddl_list();
        $searcher_conditional = [];

        // dd($searcher_ddl_list);

        if(count($searcher_ddl_list)> 0){
            foreach($searcher_ddl_list as $modal_key => $searcher_list){
                foreach($searcher_list as $key => $searcher){
                    if(isset($searcher['conditional-dependents'])){
                        foreach($searcher['conditional-dependents'] as $conditional_key => $conditional_dependent){
                            $temp_ddl = $searcher_list[$conditional_key];
                            $searcher_conditional[$modal_key.'_modal_'.$conditional_key] = ['modal' => $modal_key, 'column' => $modal_key.'_modal_'.$key, 'model_path' => $temp_ddl['ddl_model_path'], 'ddl_code' => $temp_ddl['ddl_code'], 'dependent-parameters' => $conditional_dependent['dependent-parameters'], 'subdependents' => $ddl['subdependents']??[]];
                        }
                    }
                }
            }
        }


        return $searcher_conditional;

    }

    public function get_index_columns($model_path){
        $model = new ($model_path);
        $tmp_index_columns = $model->get_columns();
        $labels = $this->get_model_labels($model);
        $index_columns = [];
        foreach ($tmp_index_columns as $key => $column) {
            switch (true) {
                case (str_contains($key, '_id')):
                        array_push($index_columns, ['name' => str_replace('_id', '_name', $key), 'label' => $labels[$key] ?? strtoupper(str_replace('_id', '_name', $key))]);
                    break;
                default:
                        array_push($index_columns, ['name' => $key, 'label' => strtoupper(str_replace('_', ' ', $key))]);
                    break;
            }
        }
        return $index_columns;
    }

    public function set_column_number($num = 3){
        switch ($num) {
            case 4:
                $col = 'col-lg-3 col-md-6 col-sm-12';
                break;

            case 3:
                $col = 'col-lg-4 col-md-6 col-sm-12';
                break;
        
            case 2:
                $col = 'col-lg-6 col-sm-12';
                break;

            case 1:
                $col = 'col-12';
                break;
            
            default:
                $col = 'col-lg-4 col-md-6 col-sm-12';
                break;
        }
        return $col;
    }

    public function index_processor($request) {
        $model = new ($this->model_path);
        $model->init_rm();
        $index_columns = $this->get_index_columns($model);

        if(isset($request['data'])){
            $new_request = [];
            foreach($request['data'] as $key => $param){
                if(isset($param['value'])){
                    $new_request[$param['name']] = $param['value'];
                }
            }
            $new_request['page'] = $request['page'];
            $request = $new_request;
        }

        $rm_select = $this->get_model_rm_select($model);
        $rm_inner_joins = $this->get_model_rm_inner_joins($model);
        $rm_left_joins = $this->get_model_rm_left_joins($model);
        $rm_right_joins = $this->get_model_rm_right_joins($model);
        $rm_cross_joins = $this->get_model_rm_cross_joins($model);

        $model_columns = $model->get_columns();
        $rm_filter_columns = $this->get_model_rm_filter_columns($model);
        
        $ddl = $this->get_model_ddl($model);
        $ddl_dynamic = $this->get_model_ddl_dynamic($model);
        $ddl_conditional = $this->get_model_ddl_conditional($model);
        $searchers = $this->get_model_searchers($model);
        $searcher_ddl = $this->get_model_searcher_ddl($model);
        $searcher_conditional = $this->get_model_searcher_conditional($model);

        $def_date = Carbon::now('UTC')->toDateString();
        $filters = [];
        if (count($rm_filter_columns)>0){
            foreach($rm_filter_columns as $key => $columns){
                switch (true) {
                    case strstr($key, '_date'):
                        if(isset($request[$key.'_from']) && isset($request[$key.'_to'])){
                            $filters[$key.'_from'] = $request[$key.'_from'];
                            $filters[$key.'_to'] = $request[$key.'_to'];
                        } 
                        else {
                            $filters[$key.'_from'] = $def_date;
                            $filters[$key.'_to'] = $def_date;
                        }
                        break;
                    default:
                        if(isset($request[$key])){
                            $filters[$key] = $request[$key];
                        }
                        break;
                }
            }
        }

        $elements = $model::when(count($rm_select)>0, function ($q) use ($rm_select){
                                return $q->select($rm_select);
                            })
                            ->when(count($rm_inner_joins)>0, function ($q) use ($rm_inner_joins){
                                foreach($rm_inner_joins as $key => $join){
                                    $q->join($join['foreign_table'], $join['foreign_id'], $join['reference_id']);
                                }
                                return $q;
                            })
                            ->when(count($rm_left_joins)>0, function ($q) use ($rm_left_joins){
                                foreach($rm_left_joins as $key => $join){
                                    $q->leftJoin($join['foreign_table'], $join['foreign_id'], $join['reference_id']);
                                }
                                return $q;
                            })
                            ->when(count($rm_right_joins)>0, function ($q) use ($rm_right_joins){
                                foreach($rm_right_joins as $key => $join){
                                    $q->rightJoin($join['foreign_table'], $join['foreign_id'], $join['reference_id']);
                                }
                                return $q;
                            })
                            ->when(count($rm_cross_joins)>0, function ($q) use ($rm_cross_joins){
                                foreach($rm_cross_joins as $key => $join){
                                    $q->crossJoin($join['foreign_table']);
                                }
                                return $q;
                            })
                            ->when(count($filters)>0, function ($q) use ($rm_filter_columns, $model_columns, $filters){
                                foreach($rm_filter_columns as $field => $table){
                                    if(isset($filters[$field])){
                                        switch (true) {
                                            case array_key_exists($field, $model_columns) && $model_columns[$field] == 'number':
                                                    $q->where($table.'.'.$field, '=', $filters[$field]);
                                                break;
                                            case array_key_exists($field, $model_columns) && $model_columns[$field] == 'text':
                                                $q->where($table.'.'.$field, 'like', '%'.$filters[$field].'%');
                                                break;
                                            case array_key_exists($field, $model_columns) && $model_columns[$field] == 'select':
                                                $q->where($table.'.'.$field, '=', $filters[$field]);
                                                break;
                                            default:
                                                $q->where($table.'.'.$field, 'like', '%'.$filters[$field].'%');
                                                break;
                                        }
                                    }
                                    if(strstr($field, '_date')){
                                        $q->whereBetween($field, [$filters[$field.'_from'], $filters[$field.'_to']]);
                                    }

                                }
                                return $q;
                            })
                            ->sortable()
                            ->paginate(env('ROW_COUNT'));


        return array(
            'elements'            => $elements, 
            'index_columns'       => $index_columns,
            'rm_filter_columns'   => $rm_filter_columns,
            'inputs'              => $model_columns,
            'prev_output'         => $filters,
            'ddl'                 => $ddl,
            'ddl_dynamic'         => $ddl_dynamic,
            'ddl_conditional'     => $ddl_conditional,
            'searchers'           => $searchers,
            'searcher_ddl'        => $searcher_ddl,
            'searcher_conditional'=> $searcher_conditional
        );
    }

    public function index(Request $request)
    {
        
        if($request->ajax()) {
            $new_request = [];
            foreach($request['data'] as $key => $param){
                $new_request[$param['name']] = $param['value'];
            }
            $index_processor = $this->index_processor($new_request);
        }else {
            $index_processor = $this->index_processor($request);  
        }

        $elements               = $index_processor['elements'];
        $index_columns          = $index_processor['index_columns'];
        $rm_filter_columns      = $index_processor['rm_filter_columns'];
        $model_columns          = $index_processor['inputs'];
        $filters                = $index_processor['prev_output'];
        $ddl                    = $index_processor['ddl'];
        $ddl_dynamic            = $index_processor['ddl_dynamic'];
        $ddl_conditional        = $index_processor['ddl_conditional'];
        $searchers              = $index_processor['searchers'];
        $searcher_ddl           = $index_processor['searcher_ddl'];
        $searcher_conditional   = $index_processor['searcher_conditional'];

        if($request->ajax()) {
            $view = view('components.index-table', [
                'elements'              => $elements,
                'index_columns'         => $index_columns,
                'route'                 => $this->route,
                'route_param'           => $this->route_param,
            ]);
            return $view;
        }

        return view ('general.index', [
            'elements'              => $elements,
            'title'                 => $this->title,
            'route'                 => $this->route,
            'route_param'           => $this->route_param,
            'index_columns'         => $index_columns,
            'filters'               => $rm_filter_columns,
            'inputs'                => $model_columns,
            'prev_output'           => $filters,
            'ddl'                   => $ddl,
            'ddl_dynamic'           => $ddl_dynamic,
            'ddl_conditional'       => $ddl_conditional,
            'searchers'             => $searchers,
            'searcher_ddl'          => $searcher_ddl,
            'searcher_conditional'  => $searcher_conditional,
            'column_num'            => $this->set_column_number($this->column_num),

        ]);
        
    }
}


