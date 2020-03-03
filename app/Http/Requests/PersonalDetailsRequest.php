<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonalDetailsRequest extends FormRequest
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
            'title' => 'required|string|email',
            'firstname' => 'required|string',
            'lastname' =>  'required',
            'date_of_birth' => 'required',
            'nationality' =>'required',
            'phone' =>'required',
            'email' => 'required',
            'web' => 'required',
            'address' => 'required',
            'profile' => 'required',
            'picture_url' => 'required',
            'interest' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'title' => 'Enter your title',
            'firstname' => 'enter your firstname',
            'lastname' =>  'Enter your lastname',
            'date_of_birth' => 'your date of birth is empty',
            'nationality' =>'Enter your Nationality',
            'phone' =>'Enter your mobile number',
            'email' => 'Enter your Email',
            'web' => 'Enter a web address',
            'address' => 'Enter your address',
            'profile' => 'Enter your profile',
            'interest' => 'Enter your interest'
        ];
    }
}
