<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class tb_sys_mf_mod_validation extends FormRequest
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
            'code'                          => 'required|max:30',
            'name'                          => 'required|max:255',
            'menu'                          => 'required|max:255',
            'url'                           => 'required|max:255',
            'is_active'                     => 'nullable',
            'mod_group_id'                  => 'required',
            'detail_mod_access_type_id.*'   => 'nullable',
            'detail_access_type_id.*'       => 'nullable',
            'detail_mod_apr_type_id.*'      => 'nullable',
            'detail_apr_type_id'            => 'nullable',

        ];
    }
}
