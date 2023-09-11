<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Str;

class IpdPatientDepartment extends Model
{
    const STATUS_ARR = [
        '' => 'All',
        0 => 'Active',
        1 => 'Discharged',
    ];

    const FILTER_STATUS_ARR = [
        0 => 'All',
        1 => 'Active',
        2 => 'Discharged',
    ];

    public static $rules = [
        'patient_id' => 'required',
        'case_id' => 'required',
        'admission_date' => 'required',
        'doctor_id' => 'required',
        'bed_type_id' => 'required',
        'bed_id' => 'required',
        'weight' => 'numeric|max:200|nullable',
        'height' => 'numeric|max:7|nullable',
        'bp' => 'numeric|max:200|nullable',
    ];

    public $fillable = [
        'patient_id',
        'ipd_number',
        'height',
        'weight',
        'bp',
        'symptoms',
        'notes',
        'admission_date',
        'case_id',
        'is_old_patient',
        'doctor_id',
        'bed_type_id',
        'bed_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'patient_id' => 'integer',
        'ipd_number' => 'string',
        'height' => 'integer',
        'weight' => 'integer',
        'bp' => 'string',
        'symptoms' => 'string',
        'notes' => 'string',
        'case_id' => 'integer',
        'is_old_patient' => 'boolean',
        'doctor_id' => 'integer',
        'bed_type_id' => 'integer',
        'bed_id' => 'integer',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function patientCase(): BelongsTo
    {
        return $this->belongsTo(PatientCase::class, 'case_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function bedType(): BelongsTo
    {
        return $this->belongsTo(BedType::class);
    }

    public function bed(): BelongsTo
    {
        return $this->belongsTo(Bed::class);
    }

    public function bedAssign(): BelongsTo
    {
        return $this->belongsTo(BedAssign::class, 'bed_id');
    }

    public function bill(): HasOne
    {
        return $this->hasOne(IpdBill::class);
    }

    public static function generateUniqueIpdNumber(): string
    {
        $ipdNumber = strtoupper(Str::random(8));
        while (true) {
            $isExist = self::whereIpdNumber($ipdNumber)->exists();
            if ($isExist) {
                self::generateUniqueIpdNumber();
            }
            break;
        }

        return $ipdNumber;
    }
}
