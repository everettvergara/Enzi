<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_wf_tr_visitation_right_party extends Model
{
    use HasFactory;

    protected $table = 'tb_wf_tr_visitation_right_party';

    protected $fillable = [
        'signature', 'attachment', 'mobile_no', 'landline_no', 'email_address', 'reason_for_default', 
        'ptp_date', 'ptp_amount', 'best_time_to_call', 'printed_name', 'time'
    ];

    public function visitation_detail() {
        return $this->belongsTo(tb_wf_tr_visitation_detail::class, "visitation_detail_id");
    }
}
