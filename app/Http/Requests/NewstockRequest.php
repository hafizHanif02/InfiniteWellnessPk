<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewstockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'in:0,1'],
        ];
    }
}
