<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dietitian extends Model
{
    use HasFactory;

    protected $table = 'dietitianassessment';

    public $fillable = [
        'patient_id',
        'age'   ,
        'weight'  ,
        'height'  ,
        'bmi'  ,
        'ibw'  ,
        'nutritionalStatusCategory'  ,
        'pastDietaryPattern'  ,
        'pastFluidIntake'  ,
        'foodAllergy'  ,
        'activityFactor'  ,
        'Diabetes'  ,
        'Hypertension'  ,
        'Stroke'  ,
        'Cancer'  ,
        'arthritis'  ,
        'chronicKidneyDisease'  ,
        'copd'  ,
        'Thyroid'  ,
        'Asthma'  ,
        'Alzheimer'  ,
        'cysticFibrosis'  ,
        'inflammatoryBowelDisease'  ,
        'osteoporosis'  ,
        'mentalIllness'  ,
        'polycysticOvarySyndrome'  ,
        'Depression'  ,
        'multipleSclerosis'  ,
        'inputEmail3'  ,
        'Breakfast'  ,
        'Midmorning'  ,
        'Lunch'  ,
        'Regimen'  ,
        'Breakfastpost'  ,
        'Midmorningpost'  ,
        'Lunchpost'  ,
        'Dinnerpost'  ,
        'Regimenpost'  ,
        'Protein'  ,
        'Carbohydrates'  ,
        'Fat'  ,
        'Fluid'  ,
        'Restriction'  ,
        'Proteincalories'  ,
        'Carbohydratescalories'  ,
        'Fatcalories'  ,
        'ProteinNutrients'  ,
        'CarbohydratesNutrients'  ,
        'FatNutrients'  ,
        'BasalEnergy'  ,
        'TotalCalories'  ,
        'date1'  ,
        'time1'  ,
        'week1'  ,
        'date2'  ,
        'time2'  ,
        'week2'  ,
        'date3'  ,
        'time3'  ,
        'week3'  ,
        'date4'  ,
        'time4'  ,
        'week4'  ,
        'date21'  ,
        'time21'  ,
        'week21'  ,
        'date22'  ,
        'time22'  ,
        'week22'  ,
        'date33'  ,
        'time33'  ,
        'week33'  ,
        'date31'  ,
        'time31'  ,
        'week31'  ,
        'date88'  ,
        'time88'  ,
        'week88'  ,
        'date42'  ,
        'time42'  ,
        'week42'  ,  
    ];
}