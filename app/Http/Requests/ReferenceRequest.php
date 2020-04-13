<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReferenceRequest extends FormRequest
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

            'company_name' => 'required',
            'name' => 'required',
            'contact_1' => 'required',
            'note' => 'required',
            'contact_2' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'company_name' => 'Enter your  company_name',
            'name' => 'Enter your Skill name',
            'contact_1' => 'Enter contact_1',
            'note' => 'Enter your Skill name',
            'contact_2' => 'Enter your skill category'
        ];
    }
}
