<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Appointment extends Model
{
    const STATUS_ARR = [
        '2' => 'All',
        '0' => 'Pending',
        '1' => 'Completed',
        '3' => 'Cancelled',
    ];

    const STATUS_PENDING = 0;

    const STATUS_COMPLETED = 1;

    const STATUS_ALL = 2;

    const STATUS_CANCELLED = 3;

    public $fillable = [
        'patient_id',
        'doctor_id',
        'doctor_department_id',
        'opd_date',
        'problem',
        'is_completed',
    ];

    protected $casts = [
        'id' => 'integer',
        'patient_id' => 'integer',
        'doctor_id' => 'integer',
        'doctor_department_id' => 'integer',
        'opd_date' => 'datetime',
        'problem' => 'string',
        'is_completed' => 'integer',
    ];

    public static $rules = [
        'patient_id' => 'required',
        'doctor_id' => 'required',
        'doctor_department_id' => 'required',
        'opd_date' => 'required',
        'problem' => 'string|nullable',
    ];

    public function prepareAppointment(): array
    {
        return [
            'id' => $this->id ?? 'N/A',
            'doctor_name' => $this->doctor->doctorUser->full_name ?? 'N/A',
            'appointment_date' => isset($this->opd_date) ? Carbon::parse($this->opd_date)->format('d M, Y') : 'N/A',
            'appointment_time' => isset($this->opd_date) ? \Carbon\Carbon::parse($this->opd_date)->isoFormat('LT') : 'N/A',
            'doctor_department' => $this->department->title ?? 'N/A',
            'doctor_image_url' => $this->doctor->doctorUser->getApiImageUrlAttribute(),
        ];
    }

    public function prepareAppointmentForDoctor(): array
    {
        return [
            'id' => $this->id ?? 'N/A',
            'patient_name' => $this->patient->patientUser->full_name ?? 'N/A',
            'appointment_date' => isset($this->opd_date) ? Carbon::parse($this->opd_date)->format('jS M, y') : 'N/A',
            'appointment_time' => isset($this->opd_date) ? \Carbon\Carbon::parse($this->opd_date)->isoFormat('LT') : 'N/A',
            'patient_image' => $this->patient->patientUser->getApiImageUrlAttribute(),
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

    public function department(): BelongsTo
    {
        return $this->belongsTo(DoctorDepartment::class, 'doctor_department_id');
    }
}
