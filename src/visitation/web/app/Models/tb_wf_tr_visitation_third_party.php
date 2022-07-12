<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_wf_tr_visitation_third_party extends Model
{
    use HasFactory;

    protected $table = 'tb_wf_tr_visitation_third_party';

    protected $fillable = [
        'printed_name', 'signature', 'attachment', 'relationship', 'mobile_no', 'landline_no', 'whereabouts', 
        'work', 'work_address'
    ];

    public function visitation_detail() {
        return $this->belongsTo(tb_wf_tr_visitation_detail::class, "visitation_detail_id");
    }
}
