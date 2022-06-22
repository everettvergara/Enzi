<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_sys_mf_mod_access_type extends Model
{
    use HasFactory;

    protected $table = 'tb_sys_mf_mod_access_type';

    protected $fillable = [
        'mod_id',
        'access_type_id',
    ];
}
