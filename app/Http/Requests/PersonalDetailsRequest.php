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
            'title' => 'required|string',
            'firstname' => 'required|string',
            'lastname' =>  'required',
            'username' => 'required',
            'date_of_birth' => 'required',
            'nationality' =>'required',
            'phone' =>'required',
            'email' => 'required',
            'address' => 'required',
            'profile' => 'required',
            'picture_url' => 'required',
            'interest' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Enter your title',
            'username.required' => 'Enter your username',
            'firstname.required' => 'enter your firstname',
            'lastname.required' =>  'Enter your lastname',
            'date_of_birth.required' => 'your date of birth is empty',
            'nationality.required' =>'Enter your Nationality',
            'phone.required' =>'Enter your mobile number',
            'email.required' => 'Enter your Email',
            'address.required' => 'Enter your address',
            'profile.required' => 'Enter your profile',
            'interest.required' => 'Enter your interest'
        ];
    }
}
