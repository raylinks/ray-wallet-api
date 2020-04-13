<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecruitmentRequest extends FormRequest
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

            'job_title' => 'required',
            'location' => 'required',
            'skills' => 'required',
            'experience' => 'required',
            'description' => 'required'
            'closing_date' => 'required',
            'requirement' => 'required',
            'responsiility' => 'required'
            'qualification' => 'required',
            'scope_of_work' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'job_title' => 'Enter your  job_title',
            'location' => 'Enter your location',
            'skills' => 'Enter skills',
            'experience' => 'Enter your experience',
            'description' => 'Enter your description',
            'closing_date' => 'Enter your closing_date',
            'requirement' => 'Enter your requirement',
            'responsiility' => 'Enter your responsiility',
            'qualification' => 'Enter your qualification',
            'scope_of_work' => 'Enter your scope_of_work'
        ];
    }
}
