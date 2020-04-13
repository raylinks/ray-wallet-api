<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AmbasadorReferalRequest extends FormRequest
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

            'full_name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'status' => 'required',
            'work' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'full_name' => 'Enter your full_name',
            'email' => 'Enter your email',
            'address' => 'Enter your address',
            'status' =>'status is required',
            'work' => 'Enter a work'
        ];
    }
}
