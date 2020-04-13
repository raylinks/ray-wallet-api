<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EducationRequest extends FormRequest
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

            'institution' => 'required',
            'field_of_study' => 'required',
            'country' => 'required',
            'city' => 'required',
            'time_from' => 'required',
            'time_to' => 'required',
            'note' => 'required',

        ];
    }
    public function messages()
    {
        return [
            'institution' => 'Enter your institution level',
            'field_of_study' => 'Enter your field_of_study name',
            'country' => 'Enter your country',
            'city' =>'city is required',
            'time_from' => 'Enter a time_from',
            'time_to' => 'Enter your time_to ',
            'note' => 'Enter your note',
          
        ];
    }
}
