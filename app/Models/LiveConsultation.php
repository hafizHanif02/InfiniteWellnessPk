<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LiveConsultation extends Model
{
    const OPD = 0;

    const IPD = 1;

    const HOST_ENABLE = 1;

    const HOST_DISABLED = 0;

    const CLIENT_ENABLE = 1;

    const CLIENT_DISABLED = 0;

    const STATUS_AWAITED = 0;

    const STATUS_CANCELLED = 1;

    const STATUS_FINISHED = 2;

    const STATUS_TYPE = [
        self::OPD => 'OPD',
        self::IPD => 'IPD',
    ];

    const status = [
        self::STATUS_AWAITED => 'Awaited',
        self::STATUS_CANCELLED => 'Cancelled',
        self::STATUS_FINISHED => 'Finished',
    ];

    const FILTER_STATUS = [
        0 => 'All',
        1 => 'Awaited',
        2 => 'Cancelled',
        3 => 'Finished',
    ];

    protected $appends = ['status_text'];

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'consultation_title',
        'consultation_date',
        'consultation_duration_minutes',
        'type',
        'type_number',
        'description',
        'created_by',
        'status',
        'meta',
        'meeting_id',
        'time_zone',
        'password',
        'host_video',
        'participant_video',
    ];

    protected $casts = [
        'doctor_id' => 'integer',
        'patient_id' => 'integer',
        'consultation_title' => 'string',
        'consultation_date' => 'date',
        'consultation_duration_minutes' => 'string',
        'type' => 'integer',
        'type_number' => 'integer',
        'description' => 'string',
        'created_by' => 'integer',
        'status' => 'integer',
        'meeting_id' => 'integer',
        'time_zone' => 'string',
        'password' => 'string',
        'host_video' => 'integer',
        'participant_video' => 'integer',
        'meta' => 'array',
    ];

    public static $rules = [
        'patient_id' => 'required',
        'doctor_id' => 'required',
        'consultation_title' => 'required',
        'consultation_date' => 'required',
        'consultation_duration_minutes' => 'required|numeric|min:0|max:720',
        'type' => 'required',
        'type_number' => 'required',
    ];

    public function prepareData(): array
    {
        return [
            'id' => $this->id,
            'consultation_title' => $this->consultation_title,
            'status' => isset($this->status) ? self::status[$this->status] : 'N/A',
            'consultation_time' => \Carbon\Carbon::parse($this->consultation_date)->format('h:i A'),
            'consultation_date' => \Carbon\Carbon::parse($this->consultation_date)->translatedFormat('jS M,Y'),
            'patient_image' => $this->patient->patientUser->getApiImageUrlAttribute(),
        ];
    }

    public function prepareDataForDetail(): array
    {
        return [
            'id' => $this->id,
            'consultation_title' => $this->consultation_title,
            'consultation_date' => \Carbon\Carbon::parse($this->consultation_date)->translatedFormat('jS M,Y - h:i A'),
            'duration_minutes' => $this->consultation_duration_minutes,
            'patient_name' => $this->patient->patientUser->full_name,
            'type' => $this->type ? 'IPD' : 'OPD',
            'type_number' => $this->type == 0 ? $this->opdPatient ? $this->opdPatient->opd_number : 'N/A' : $this->ipdPatient->ipd_number,
        ];
    }

    public function prepareDataForMeeting(): array
    {
        return [
            'consultation_title' => $this->consultation_title,
            'status' => $this->status == 0 ? 'Awaited' : 'N/A',
            'host_video' => ! $this->host_video ? $this->user->full_name : 'N/A',
            'consultation_date' => $this->consultation_date,
            'duration_minutes' => $this->consultation_duration_minutes.' '.'Minutes',
            'meta' => $this->meta['start_url'],
        ];
    }

    public function getStatusTextAttribute()
    {
        return self::status[$this->status];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function ipdPatient(): BelongsTo
    {
        return $this->belongsTo(IpdPatientDepartment::class, 'type_number');
    }

    public function opdPatient(): BelongsTo
    {
        return $this->belongsTo(OpdPatientDepartment::class, 'type_number');
    }

    public function prepareLiveConsultation(): array
    {
        return [
            'id' => $this->id,
            'consultation_title' => $this->consultation_title ?? 'N/A',
            'consultation_date' => isset($this->consultation_date) ? \Carbon\Carbon::parse($this->consultation_date)->format('jS M, Y') : 'N/A',
            'consultation_time' => isset($this->consultation_date) ? \Carbon\Carbon::parse($this->consultation_date)->format('h:i A') : 'N/A',
            'status' => isset($this->status) ? self::status[$this->status] : 'N/A',
            'doctor_image' => $this->doctor->doctorUser->getApiImageUrlAttribute() ?? 'N/A',
        ];
    }

    public function scopeFilter($query)
    {
        if (request()->status) {
            $request = request();
            $query->when(isset($request->status), function (Builder $q) use ($request) {
                if ($request->status == 1) {
                    $q->where('status', LiveConsultation::STATUS_AWAITED);
                }
                if ($request->status == 2) {
                    $q->where('status', LiveConsultation::STATUS_CANCELLED);
                }
                if ($request->status == 3) {
                    $q->where('status', LiveConsultation::STATUS_FINISHED);
                }
            });
        }

        return $query;
    }

    public function prepareLiveConsultationDetail(): array
    {
        return [
            'id' => $this->id,
            'consultation_title' => $this->consultation_title ?? 'N/A',
            'consultation_date' => isset($this->consultation_date) ? \Carbon\Carbon::parse($this->consultation_date)->translatedFormat('jS M,Y - h:i A') : 'N/A',
            'duration' => $this->consultation_duration_minutes ?? 'N/A',
            'dostor_name' => $this->doctor->doctorUser->full_name,
            'type' => isset($this->type) ? self::STATUS_TYPE[$this->type] : 'N/A',
            'type_number' => $this->getTypeNumber($this->type, $this->patient_id),
        ];
    }

    public function getTypeNumber($type, $patientId)
    {
        if (self::OPD == $type) {
            return OpdPatientDepartment::where('patient_id', $patientId)->first()->opd_number ?? 'N/A';
        }

        return IpdPatientDepartment::where('patient_id', $patientId)->first()->ipd_number ?? 'N/A';
    }
}
