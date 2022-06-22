<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_sys_mf_mod_approval_hierarchy_type extends Model
{
    use HasFactory;

    protected $table = 'tb_sys_mf_mod_approval_hierarchy_type';

    protected $fillable = [
        'mod_id',
        'approval_type_id',
    ];
}
