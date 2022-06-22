<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class tb_sys_mf_mod_group_validation extends FormRequest
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
            'code'       => 'required|max:30',
            'name'       => 'required|max:255',
            'menu'       => 'required|max:255',
            'is_active'  => 'nullable',
            'ref_mod_id' => 'nullable',
            'seq'        => 'nullable|integer'
        ];
    }
}
