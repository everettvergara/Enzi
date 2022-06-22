<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class tb_crm_tr_sample_validation extends FormRequest
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
            'sample_date' => 'required',
            'code' => 'required|max:30',
            'name'  => 'required|max:255',
            'remarks'    => 'nullable',
            'status_id' => 'nullable',
        ];
    }
}
