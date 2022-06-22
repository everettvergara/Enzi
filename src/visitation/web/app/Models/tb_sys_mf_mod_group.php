<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class tb_sys_mf_mod_group extends Model
{
    use HasFactory, Sortable;

    protected $table = 'tb_sys_mf_mod_group';

    protected $fillable = [
        'code',
        'name',
        'menu',
        'ref_mod_id',
        'seq',
        'is_active',
    ];

    public $sortable = ['id', 'code', 'name', 'menu', 'ref_mod_id', 'seq', 'is_active'];

    public $sortableAs = ['ref_mod_name'];

    public function parent()
    {
        return $this->belongsTo('App\Models\tb_sys_mf_mod_group', 'ref_mod_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\tb_sys_mf_mod_group', 'ref_mod_id');
    }
    
    public static function tree(){
        return static::with(implode('.', array_fill(0,4, 'children')))->where('ref_mod_id', '=', null)->orderBy('seq', 'asc')->get();
    }

}
