<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeathReport extends Model
{
    public $fillable = [
        'patient_id',
        'case_id',
        'doctor_id',
        'date',
        'description',
    ];

    protected $casts = [
        'id' => 'integer',
        'patient_id' => 'integer',
        'case_id' => 'string',
        'doctor_id' => 'integer',
    ];

    public static $rules = [
        'case_id' => 'required|unique:death_reports,case_id',
        'doctor_id' => 'required',
        'date' => 'required',
        'description' => 'nullable|string',
    ];

    public function prepareData(): array
    {
        return [
            'id' => $this->id,
            'patient_name' => $this->patient->patientUser->full_name,
            'patient_image' => $this->patient->patientUser->getApiImageUrlAttribute(),
            'case_id' => $this->caseFromDeathReport->case_id,
            'date' => isset($this->date) ? \Carbon\Carbon::parse($this->date)->translatedFormat('jS M, Y') : 'N/A',
            'time' => isset($this->date) ? \Carbon\Carbon::parse($this->date)->isoFormat('LT') : 'N/A',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function caseFromDeathReport(): BelongsTo
    {
        return $this->belongsTo(PatientCase::class, 'case_id', 'case_id');
    }
}
