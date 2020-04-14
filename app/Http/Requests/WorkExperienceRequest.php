<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkExperienceRequest extends FormRequest
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

            'company_name' => 'required',
            'job_title' => 'required',
            'country' => 'required',
            'city' => 'required',
            'time_from' => 'required',
            'time_to' => 'required',
            'currently_work' => 'required',
            'note' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'company_name' => 'Enter your company_name',
            'job_title' => 'Enter job_title',
            'country' => 'Enter your country',
            'city' => 'Enter your city',
            'time_from' => 'Enter your time_from',
            'time_to' => 'Enter your time_to',
            'currently_work' => 'Enter your currently_work',
            'note' => 'Enter your note',
        ];
    }
}
