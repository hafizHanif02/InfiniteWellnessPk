<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class BedAssign extends Model
{
    public $fillable = [
        'bed_id',
        'ipd_patient_department_id',
        'patient_id',
        'case_id',
        'assign_date',
        'discharge_date',
        'description',
        'status',
    ];

    const STATUS_ALL = 2;

    const ACTIVE = 1;

    const INACTIVE = 0;

    const STATUS_ARR = [
        self::STATUS_ALL => 'All',
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Deactive',
    ];

    const FILTER_STATUS_ARR = [
        0 => 'All',
        1 => 'Active',
        2 => 'Deactive',
    ];

    protected $casts = [
        'id' => 'integer',
        'bed_id' => 'integer',
        'ipd_patient_department_id' => 'integer',
        'patient_id' => 'integer',
        'case_id' => 'string',
        'assign_date' => 'date',
        'discharge_date' => 'date',
        'description' => 'string',
        'status' => 'integer',
    ];

    public static $rules = [
        'bed_id' => 'required',
        'case_id' => 'required',
        'assign_date' => 'required',
        'discharge_date' => 'nullable|after:assign_date',
        'description' => 'nullable|string',
    ];

    public function prepareData(): array
    {
        return [
            'id' => $this->id,
            'patient_name' => $this->patient->patientUser->full_name,
            'bed_id' => $this->bed_id,
            'bed' => $this->bed->name,
            'case_id' => $this->caseFromBedAssign->case_id,
            'assign_date' => isset($this->assign_date) ? Carbon::parse($this->assign_date)->format('jS M, Y') : 'N/A',
            'assign_time' => isset($this->assign_date) ? \Carbon\Carbon::parse($this->assign_date)->isoFormat('LT') : 'N/A',
            'patient_image' => $this->patient->patientUser->getApiImageUrlAttribute(),
        ];
    }

    public function dataForEdit(): array
    {
        return [
            'id' => $this->id,
            'case_id' => $this->case_id ?? 'N/A',
            'patient_name' => $this->patient->patientUser->full_name ?? 'N/A',
            'ipd_patient' => $this->ipdPatient->ipd_number ?? 'N/A',
            'bed' => $this->bed->name ?? 'N/A',
            'assign_date' => isset($this->assign_date) ? Carbon::parse($this->assign_date)->format('Y-m-d H:i:s') : 'N/A',
            'discharge_date' => isset($this->discharge_date) ? Carbon::parse($this->discharge_date)->format('Y-m-d H:i:s') : 'N/A',
            'description' => $this->description ?? 'N/A',
        ];
    }

    public function prepareBedAssignData(): array
    {
        return [
            'bed' => $this->bed->name ?? 'N/A',
            'bed_type' => $this->bed->bedType->title ?? 'N/A',
            'bed_id' => $this->bed->bed_id ?? 'N/A',
            'charge' => $this->bed->charge ?? 'N/A',
            'is_available' => $this->bed->is_available,
            'created_on' => \Carbon\Carbon::parse($this->created_at)->diffForHumans() ?? 'N/A',
            'description' => $this->bed->description ?? 'N/A',
            'currency_symbol' => getCurrencySymbol() ?? 'N/A',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function bed(): BelongsTo
    {
        return $this->belongsTo(Bed::class);
    }

    public function caseFromBedAssign(): BelongsTo
    {
        return $this->belongsTo(PatientCase::class, 'case_id', 'case_id');
    }

    public function ipdPatient(): BelongsTo
    {
        return $this->belongsTo(IpdPatientDepartment::class);
    }
}
