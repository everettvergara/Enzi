<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_wf_tr_visitation_detail extends Model
{
    use HasFactory;

    protected $table = 'tb_wf_tr_visitation_detail';

    protected $fillable = [
        'date_visited'
    ];

    public function visitation() 
    {
        return $this->belongsTo(tb_wf_tr_visitation::class, "visitation_id");
    }

    public function contract() {
        return $this->belongsTo(contract_master::class, "cm_id");
    }

    public function right_party() {
        return $this->hasOne(tb_wf_tr_visitation_right_party::class, "visitation_detail_id");
    }

    public function third_party() {
        return $this->hasOne(tb_wf_tr_visitation_third_party::class, "visitation_detail_id");
    }

    public function negative() {
        return $this->hasOne(tb_wf_tr_visitation_negative_party::class, "visitation_detail_id");
    }
}
