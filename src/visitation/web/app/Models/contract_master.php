<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class contract_master extends Model
{
    use HasFactory;

    protected $table = 'contract_master';
    protected $primaryKey = "cm_id";

    public function getAccountNameAttribute() {
        $an = DB::select("select dbo.fn_xorencrypt(?) an", [$this->attributes['account_name']])[0]->an;
        return $an;
    }

    public function getAccountNumberAttribute() {
        $an = DB::select('SELECT dbo.fn_xorencrypt(?) AS an', [$this->attributes['account_number']])[0]->an;
        return $an;
     }
}
