<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DietitianRequest extends FormRequest
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
        'patient_id' => 'nullable',
        'age'   => 'nullable',
        'weight'  => 'nullable',
        'height'  => 'nullable',
        'bmi'  => 'nullable',
        'ibw'  => 'nullable',
        'nutritionalStatusCategory'  => 'nullable',
        'pastDietaryPattern'  => 'nullable',
        'pastFluidIntake'  => 'nullable',
        'foodAllergy'  => 'nullable',
        'activityFactor'  => 'nullable',
        'Diabetes'  => 'nullable',
        'Hypertension'  => 'nullable',
        'Stroke'  => 'nullable',
        'Cancer'  => 'nullable',
        'arthritis'  => 'nullable',
        'chronicKidneyDisease'  => 'nullable',
        'copd'  => 'nullable',
        'Thyroid'  => 'nullable',
        'Asthma'  => 'nullable',
        'Alzheimer'  => 'nullable',
        'cysticFibrosis'  => 'nullable',
        'inflammatoryBowelDisease'  => 'nullable',
        'osteoporosis'  => 'nullable',
        'mentalIllness'  => 'nullable',
        'polycysticOvarySyndrome'  => 'nullable',
        'Depression'  => 'nullable',
        'multipleSclerosis'  => 'nullable',
        'inputEmail3'  => 'nullable',
        'Breakfast'  => 'nullable',
        'Midmorning'  => 'nullable',
        'Lunch'  => 'nullable',
        'Regimen'  => 'nullable',
        'Breakfastpost'  => 'nullable',
        'Midmorningpost'  => 'nullable',
        'Lunchpost'  => 'nullable',
        'Dinnerpost'  => 'nullable',
        'Regimenpost'  => 'nullable',
        'Protein'  => 'nullable',
        'Carbohydrates'  => 'nullable',
        'Fat'  => 'nullable',
        'Fluid'  => 'nullable',
        'Restriction'  => 'nullable',
        'Proteincalories'  => 'nullable',
        'Carbohydratescalories'  => 'nullable',
        'Fatcalories'  => 'nullable',
        'ProteinNutrients'  => 'nullable',
        'CarbohydratesNutrients'  => 'nullable',
        'FatNutrients'  => 'nullable',
        'BasalEnergy'  => 'nullable',
        'TotalCalories'  => 'nullable',
        'date1'  => 'nullable',
        'time1'  => 'nullable',
        'week1'  => 'nullable',
        'date2'  => 'nullable',
        'time2'  => 'nullable',
        'week2'  => 'nullable',
        'date3'  => 'nullable',
        'time3'  => 'nullable',
        'week3'  => 'nullable',
        'date4'  => 'nullable',
        'time4'  => 'nullable',
        'week4'  => 'nullable',
        'date21'  => 'nullable',
        'time21'  => 'nullable',
        'week21'  => 'nullable',
        'date22'  => 'nullable',
        'time22'  => 'nullable',
        'week22'  => 'nullable',
        'date33'  => 'nullable',
        'time33'  => 'nullable',
        'week33'  => 'nullable',
        'date31'  => 'nullable',
        'time31'  => 'nullable',
        'week31'  => 'nullable',
        'date88'  => 'nullable',
        'time88'  => 'nullable',
        'week88'  => 'nullable',
        'date42'  => 'nullable',
        'time42'  => 'nullable',
        'week42'  => 'nullable',
        ];
    }
}
