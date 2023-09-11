<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class GenericRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'formula' => ['required', 'string', 'max:255', $this->method() == 'POST' ? 'unique:generics,formula' : ''],
            'generic_detail' => ['nullable', 'string'],
        ];
    }
}
