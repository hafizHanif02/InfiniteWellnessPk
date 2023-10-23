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
            'total_amount' => ['required', 'numeric'],
            'pos_fees' => ['required', 'numeric'],
            'total_discount'=> ['nullable','numeric'],
            'total_saletax'=> ['nullable','numeric'],
            'total_amount_ex_saletax'=> ['nullable','numeric'],
            'total_amount_inc_saletax'=> ['nullable','numeric'],
            'patient_name' => ['required', 'string'],
            'patient_number' => ['nullable', 'string'],
            'patient_mr_number' => ['nullable', 'string'],
            'doctor_name' => ['nullable', 'string'],
            'cashier_name' => ['nullable', 'string'],
            'pos_date' => ['required', 'date'],
            'enter_payment_amount' => ['nullable', 'numeric'],
            'change_amount' => ['nullable', 'numeric'],
        ];
    }
}
