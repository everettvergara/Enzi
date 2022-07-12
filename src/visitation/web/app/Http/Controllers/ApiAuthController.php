<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Models\sys_user;

use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller
{

    public function register(Request $request) {

        $input = $request->all();
       
        
        Validator::make($input, [
            'user_code' => ['required', 'string', 'max:20', 'unique:sys_user'],
            'password' => ['required', 'string', 'min:8', 'max:20'],
            'first_name' => ['required', 'string', 'max:100'],
            'middle_name' => ['string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email_address' => ['required', 'string', 'email', 'max:50', 'unique:sys_user']
        ]);

        $user= sys_user::create([
            'user_code' =>$request->user_code,
            'password' => bcrypt($request->password),
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'super' => false,
            'active' => true,
            'last_login' => date("Y-m-d H:i"),
            'failed_attempts' => 0,
            'last_pass_changed' => date("Y-m-d H:i"),
            'email_address' => $request->email_address,
            'session' => 0,
            'login_status_id' => 10,
            'last_status_update' => date("Y-m-d H:i"),
            'user_level_id' => 15,
            'require_password_change' => 1
        ]);

        $access_token = $user->createToken('enzi_token')->accessToken;

        $user_data = [
            'erp_id' => $user->user_id,
            'code' => $user->user_code,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email_address,
            'is_active' => $user->is_active,
            'api_token' => $access_token
        ];

        return response()->json([
            'status' => 'Success',
            'data' => $user_data
        ], 200);
    }

    public function login(Request $request) {

        $login_credentials = [
            'user_code' => $request->user_code,
            'password' => $request->password,
        ];

        if(Auth::attempt($login_credentials)){
            //generate the token for the user
            $access_token = auth()->user()->createToken('enzi_token')->accessToken;

            $user = auth()->user();

            $user_data = [
                'erp_id' => $user->user_id,
                'code' => $user->user_code,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email_address,
                'is_active' => $user->is_active,
                'api_token' => $access_token
            ];
    
            return response()->json([
                'status' => 'Success',
                'data' => $user_data
            ], 200);
        }
        else{
            //wrong login credentials, return, user not authorised to our system, return error code 401
            //throw new Exception("Error Processing Request", 1);
            return response()->json([
                "status" => "Failed",
                "message" => "Unauthorized"
            ], 401);
        }
    }

    public function authenticatedUserDetails(){
        //returns details
        return response()->json(['authenticated-user' => auth()->user()], 200);
    }
}
