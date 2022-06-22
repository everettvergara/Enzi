<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class tb_sys_mf_user_validation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                      => 'required',
            'email'                     => 'required|email|unique:tb_sys_mf_user,email',
            'password'                  => 'required',
            'image'                     => 'nullable|mimes:jpg,png,jpeg|max:5048',
            'confirm_password'          => 'required', 
            'detail_access_type_id.*'   => 'nullable',
            'detail_apr_type_id.*'      => 'nullable',
            'is_admin'                  => 'nullable',
            'is_active'                     => 'nullable',
        ];
    }
}
