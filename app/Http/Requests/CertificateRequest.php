<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertificateRequest extends FormRequest
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

            'name' => 'required',
            'authority' => 'required',
            'url' => 'required',
            'date' => 'required',
        
        ];
    }
    public function messages()
    {
        return [
            'name' => 'Enter your Skill level',
            'authority' => 'Enter your Skill name',
            'url' => 'Enter your skill category',
            'date' =>'date is required',
        ];
    }
}
