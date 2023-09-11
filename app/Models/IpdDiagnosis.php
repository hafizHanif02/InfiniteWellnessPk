<?php

namespace App\Models;

use Eloquent as Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class IpdDiagnosis extends Model implements HasMedia
{
    use InteractsWithMedia;

    public const IPD_DIAGNOSIS_PATH = 'ipd_diagnosis';

    public $table = 'ipd_diagnoses';

    public $fillable = [
        'ipd_patient_department_id',
        'report_type',
        'report_date',
        'description',
    ];

    protected $casts = [
        'id' => 'integer',
        'ipd_patient_department_id' => 'integer',
        'report_type' => 'string',
        'report_date' => 'date',
        'description' => 'string',
    ];

    public static $rules = [
        'report_type' => 'required',
        'report_date' => 'required',
        'file' => 'nullable|mimes:jpeg,png,pdf,docx,doc',
    ];

    protected $appends = ['ipd_diagnosis_document_url'];

    public function getIpdDiagnosisDocumentUrlAttribute()
    {
        $media = $this->media->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return '';
    }
}
