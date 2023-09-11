<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BirthReport extends Model
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
        'case_id' => 'string',
        'patient_id' => 'integer',
        'date' => 'date',
        'description' => 'string',
        'doctor_id' => 'integer',
    ];

    public static $rules = [
        'case_id' => 'required|unique:birth_reports,case_id',
        'doctor_id' => 'required',
        'date' => 'required',
        'description' => 'nullable|string',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function caseFromBirthReport(): BelongsTo
    {
        return $this->belongsTo(PatientCase::class, 'case_id', 'case_id');
    }

    public function prepareBirthReport(): array
    {
        return [
            'id' => $this->id,
            'patient_name' => $this->patient->patientUser->full_name ?? 'N/A',
            'patient_image' => $this->patient->patientUser->api_image_url ?? 'N/A',
            'case_id' => $this->case_id ?? 'N/A',
            'date' => isset($this->date) ? Carbon::parse($this->date)->format('d F y') : 'N/A',
            'time' => isset($this->date) ? Carbon::parse($this->date)->format('h:i A') : 'N/A',
        ];
    }
}
