<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LabelRequest extends FormRequest
{
   
    public function authorize()
    {
        return true;
       
}

public function rules()
{
    return [
        'pos_id' => ['required'],
        'medicine_id' => ['required', 'exists:medicines,id'],
        'patient_id' => ['nullable', 'string', 'max:255'],
        'name' => ['required', 'exists:medicines,name'],
        // 'brand_name' => 'required',
        // 'brand_id' => ['required', 'exists:brands,id'],
        'quantity' => ['required', 'numeric'],
        'patient_name' => ['required','string'],
        'direction_use' => ['nullable', 'string'],
        'common_side_effect' => ['required', 'string'],
    ];
}


    
}
