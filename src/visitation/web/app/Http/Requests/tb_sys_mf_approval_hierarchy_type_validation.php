<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class tb_sys_mf_approval_hierarchy_type_validation extends FormRequest
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
            'name'              => 'required|max:255',
            'code'              => 'required|max:30',
            'description'       => 'nullable',
            'is_active'         => 'nullable',
        ];
    }
}
