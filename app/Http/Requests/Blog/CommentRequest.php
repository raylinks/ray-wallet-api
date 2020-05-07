<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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

            'post_id' => 'required',
            'comment' => 'required'

        ];
    }
    public function messages()
    {
        return [
            'post_id.required' => 'post_id is required',
            'comment.required' => 'comment is required'

        ];
    }
}