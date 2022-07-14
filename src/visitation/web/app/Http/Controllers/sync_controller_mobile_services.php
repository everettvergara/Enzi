<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class sync_controller_mobile_services extends Controller
{
    public function sync_syslogs(Request $r)
    {
        try {
            $user_code = auth()->user()->user_code;

            foreach($r->data as $key => $datum){
                $epoch = substr($datum['log_time'], 0, 10);
                $year = date("Y", $epoch);
                $month = date("m", $epoch);
                $day = date("d", $epoch);
                $file_path = "Mobile-Services/".$year."/".$month."/".$day."/".$r->user_code;
    
                if(is_dir($file_path) === false){
                    mkdir($file_path, 0777, true);
                }
    
                if(file_exists($file_path."/services.json")){
                    file_put_contents($file_path."/services.json", ",\r\n", FILE_APPEND | LOCK_EX);
                    file_put_contents($file_path."/services.json", json_encode($datum), FILE_APPEND | LOCK_EX);
                }
                else {
                    file_put_contents($file_path."/services.json", json_encode($datum), LOCK_EX);
                }
            }
            return json_encode([
                'status' => 'Success'
            ]);
        } catch (\Throwable $th) {
            return json_encode([
                'status' => 'Failed',
                'message' => 'Failed to save GPS'
            ]);
        }
    }
}
