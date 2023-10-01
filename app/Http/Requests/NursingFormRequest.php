<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NursingFormRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
        'patient_mr_number' => 'required',
        'opd_id' => 'required',
        'blood_pressure' => 'nullable',
        'heart_rate'  => 'nullable',
        'respiratory_rate'  => 'nullable',
        'temperature'  => 'nullable',
        'height'  => 'nullable',
        'weight'  => 'nullable',
        'pain_level'  => 'nullable',
        'assessment_date'  => 'nullable',
        'nurse_name'  => 'nullable',
        ];
    }
}
