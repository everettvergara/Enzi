<?php

namespace App\Http\Controllers;

use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class mobile_services_controller extends Controller
{
    public function create(Request $r)
    {
        // $auth = new authentication_controller();
        // if(!$auth->check_token($r->user_code, $r->device_imei, $r->token))
        //     return $auth->auth_fail_error();

        try {
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
            return $this->transaction_failed_error($th->getMessage());
        }
    }

    public function retrieve_all_date_range(Request $r){
        // $auth = new authentication_controller();
        // if(!$auth->check_token($r->user_code, $r->device_imei, $r->token))
        //     return $auth->auth_fail_error();

        try {
            $date_from = date('Y-m-d', strtotime($r->date_from));
            $date_to = date('Y-m-d', strtotime($r->date_to));
            $period = CarbonPeriod::create($date_from, $date_to);
            $date_range = $period->toArray();
            $result = '';
            $result .= "[";

            foreach ($date_range as $date_key => $date){
                $year = date_format($date, 'Y');
                $month = date_format($date, 'm');
                $day = date_format($date, 'd');
                $dir = "Mobile-Services/".$year."/".$month."/".$day;
                if(file_exists($dir) && count(scandir($dir)) > 0){
                    $users = scandir($dir);
                    foreach($users as $user){
                        $file = $dir."/".$user."/services.json";
                        if(file_exists($file)){
                            if($date_key !== array_key_first($date_range)){
                                $result .= ",\r\n";
                            }
                            $result .= file_get_contents($file);
                        }
                    }
                }
            }
            
            $result .= "]";
            return json_encode([
                'status' => 'Success',
                'data'  => $result
            ]);
        } catch (\Throwable $th) {
            return $this->transaction_failed_error($th->getMessage());
        }
    }

    public function retrieve_user_date_range(Request $r){
        // $auth = new authentication_controller();
        // if(!$auth->check_token($r->user_code, $r->device_imei, $r->token))
        //     return $auth->auth_fail_error();

        try {
            $date_from = date('Y-m-d', strtotime($r->date_from));
            $date_to = date('Y-m-d', strtotime($r->date_to));
            $period = CarbonPeriod::create($date_from, $date_to);
            $date_range = $period->toArray();
            $result = '';
            $result .= "[";

            foreach ($date_range as $date_key => $date){
                $year = date_format($date, 'Y');
                $month = date_format($date, 'm');
                $day = date_format($date, 'd');
                $dir = "Mobile-Services/".$year."/".$month."/".$day.'/'.$r->user_code;
                $file = $dir."/services.json";
                if(file_exists($file)){
                    if($date_key !== array_key_first($date_range)){
                        $result .= ",\r\n";
                    }
                    $result .= file_get_contents($file);
                }
            }

            $result .= "]";
            return json_encode([
                'status' => 'Success',
                'data'  => $result
            ]);
        } catch (\Throwable $th) {
            return $this->transaction_failed_error($th->getMessage());
        }
    }

    public function retrieve_user_date(Request $r){
        // $auth = new authentication_controller();
        // if(!$auth->check_token($r->user_code, $r->device_imei, $r->token))
        //     return $auth->auth_fail_error();

        try {
            $result = '';
            $result .= "[";
            $year = date('Y', strtotime($r->date));
            $month = date('m', strtotime($r->date));
            $day = date('d', strtotime($r->date));

            $dir = "Mobile-Services/".$year."/".$month."/".$day.'/'.$r->user_code;
            $file = $dir."/services.json";
            if(file_exists($file)){
                $result .= file_get_contents($file);
            }

            $result .= "]";
            return json_encode([
                'status' => 'Success',
                'data'  => $result
            ]);
        } catch (\Throwable $th) {
            return $this->transaction_failed_error($th->getMessage());
        }
    }

    public function retrieve_gps($user_code, $date_from, $date_to){
        $period = CarbonPeriod::create(date('Y-m-d', strtotime($date_from)), date('Y-m-d', strtotime($date_to)));
        $date_range = $period->toArray();

        $output = '';
        $output .= "[";
        foreach ($date_range as $date_key => $date){

            $year = date_format($date, 'Y');
            $month = date_format($date, 'm');
            $day = date_format($date, 'd');
            $dir = "Mobile-Services/".$year."/".$month."/".$day.'/'.$user_code;
            $file = $dir."/services.json";
            if(file_exists($file)){

                if ($output != "[") {
                    $output .= ",\r\n";
                }
                $output .= file_get_contents($file);
            }
        }
        $output .= "]";       
        return json_decode($output,true);
    }

    protected function transaction_failed_error($error){
        return json_encode([
            'status'    => 'Failed',
            'error'     => $error
        ]);
    }
}
