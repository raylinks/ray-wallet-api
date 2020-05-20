<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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

            'body' => 'required',
            'title'=> 'required',
            'image' => 'required|nullable|mimes:jpeg,jpg,png,gif',

        ];
    }
    public function messages()
    {
        return [
            'body.required' => 'content is required',
            'title.required'  => 'title is required'

        ];
    }
}
