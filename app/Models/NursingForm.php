<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NursingForm extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_mr_number',
        'opd_id',
        'blood_pressure',
        'heart_rate',
        'respiratory_rate',
        'temperature',
        'height',
        'weight',
        'pain_level',
        'assessment_date',
        'nurse_name',
    ];

    
}
