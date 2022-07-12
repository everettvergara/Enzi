<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_wf_tr_visitation_negative_party extends Model
{
    use HasFactory;

    protected $table = 'tb_wf_tr_visitation_negative_party';

    protected $fillable = [
        'reason', 'source_of_information', 'time'
    ];

    public function visitation_detail() {
        return $this->belongsTo(tb_wf_tr_visitation_detail::class, "visitation_detail_id");
    }
}
