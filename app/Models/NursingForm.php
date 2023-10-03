<?php

namespace App\Models;

use App\Models\Patient;
use App\Models\Allergies;
use App\Models\Medication;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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


    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class,'patient_mr_number','MR');
    }

    public function Allergies(): HasMany
    {
        return $this->hasMany(Allergies::class);
    }

    public function Medication(): HasMany
    {
        return $this->hasMany(Medication::class);
    }
    
}
