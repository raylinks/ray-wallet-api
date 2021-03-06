<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'required|string|unique:users|email',
            'name' => 'required|string',
            'password' => 'required|string'
        ];
    }
    public function messages()
    {
        return [
            "email.required" => "Enter a valid email address",
            'name.required' =>  'Enter a valid name',
            "password.required" => "Enter your password"
        ];
    }
}
