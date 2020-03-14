<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkillRequest extends FormRequest
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

            'skill_level' => 'required',
            'skill_name' => 'required',
            'skill_category' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'skill_level' => 'Enter your Skill level',
            'skill_name' => 'Enter your Skill name',
            'skill_category' => 'Enter your skill category'
        ];
    }
}
