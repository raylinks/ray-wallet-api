<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AwardRequest extends FormRequest
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

            'title' => 'required',
            'issuer' => 'required',
            'web_url' => 'required',
            'date' => 'required',
            'note' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'title' => 'Enter your Skill level',
            'issuer' => 'Enter your Skill name',
            'web_url' => 'Enter your skill category',
            'date' =>'date is required',
            'note' => 'Enter a text'
        ];
    }
}
