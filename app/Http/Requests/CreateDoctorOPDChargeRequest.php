<?php

namespace App\Http\Requests;

use App\Models\DoctorOpdCharge;
use Illuminate\Foundation\Http\FormRequest;

class CreateDoctorOPDChargeRequest extends FormRequest
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
        return DoctorOpdCharge::$rules;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return DoctorOpdCharge::$messages;
    }
}
