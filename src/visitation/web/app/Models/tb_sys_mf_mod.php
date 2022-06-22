<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class tb_sys_mf_mod extends Model
{
    use HasFactory, Sortable;

    protected $table = 'tb_sys_mf_mod';

    protected $fillable = [
        'code',
        'name',
        'menu',
        'mod_group_id',
        'url',
        'is_active',
        'detail_access_type_id',
    ];

    public $sortable = ['id', 'code', 'name', 'menu', 'mod_group_id', 'is_active', 'url'];

    public $sortableAs = ['mod_group_name'];

    public function tb_sys_mf_mod_group(){
        return $this->hasMany('App\Models\tb_sys_mf_mod_group', 'mod_group_id', 'id');
    }

}



    
 	 		