<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CvformatRequest extends FormRequest
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
            'image' => 'required|nullable|mimes:jpeg,jpg,png,gif',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Enter your name',
            'image.required' => 'Enter your image'

        ];
    }
}
