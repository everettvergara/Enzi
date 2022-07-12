<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_wf_tr_visitation extends Model
{
    use HasFactory;

    protected $table = 'tb_wf_tr_visitation';

    public function visitation_details() 
    {
        return $this->hasMany(tb_wf_tr_visitation_detail::class, 'visitation_id');
    }
}
