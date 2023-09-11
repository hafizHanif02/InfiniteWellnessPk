<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class InvestigationReport extends Model implements HasMedia
{
    use InteractsWithMedia;

    const STATUS = [self::NOT_SOLVED => 'Not Solved', self::SOLVED => 'Solved'];

    const STATUS_ALL = 0;

    const SOLVED = 1;

    const NOT_SOLVED = 2;

    const STATUS_ARR = [
        self::STATUS_ALL => 'All',
        self::SOLVED => 'Solved',
        self::NOT_SOLVED => 'Not Solved',
    ];

    const COLLECTION_REPORTS = 'reports';

    public $fillable = [
        'patient_id',
        'date',
        'title',
        'description',
        'doctor_id',
        'status',
    ];

    protected $casts = [
        'id' => 'integer',
        'patient_id' => 'integer',
        'date' => 'datetime',
        'title' => 'string',
        'description' => 'string',
        'doctor_id' => 'integer',
        'status' => 'integer',
    ];

    protected $appends = ['attachment_url'];

    public static $rules = [
        'patient_id' => 'required|unique:investigation_reports,patient_id',
        'date' => 'required|date',
        'title' => 'required|string',
        'doctor_id' => 'required',
        'status' => 'required',
    ];

    public static $messages = [
        'patient_id.unique' => 'The patient name has already been taken.',
        'attachment.mimes' => 'The document must be a file of type: jpeg, jpg, png, pdf, doc, docx.',
    ];

    public function prepareData(): array
    {
        return [
            'id' => $this->id,
            'patient_name' => $this->patient->patientUser->full_name,
            'patient_image' => $this->patient->patientUser->getApiImageUrlAttribute(),
            'title' => $this->title,
            'attachment' => $this->attachment_url,
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

    public function getAttachmentUrlAttribute()
    {
        $media = $this->media->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }
    }
}
