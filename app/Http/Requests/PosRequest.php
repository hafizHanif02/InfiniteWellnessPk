<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PosRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'prescription_id' => ['nullable', 'exists:prescriptions,id'],
            'total_amount' => ['required', 'numeric'],
            'patient_name' => ['required', 'string'],
            'doctor_name' => ['nullable', 'string'],
            'pos_date' => ['required', 'date'],
            'given_amount' => ['nullable', 'numeric'],
            'change_amount' => ['nullable', 'numeric'],
        ];
    }
}
