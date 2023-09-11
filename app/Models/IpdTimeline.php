<?php

namespace App\Models;

use Eloquent as Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class IpdTimeline extends Model implements HasMedia
{
    use InteractsWithMedia;

    public const IPD_TIMELINE_PATH = 'ipd_timelines';

    public $fillable = [
        'ipd_patient_department_id',
        'title',
        'date',
        'description',
        'visible_to_person',
    ];

    protected $casts = [
        'id' => 'integer',
        'ipd_patient_department_id' => 'integer',
        'title' => 'string',
        'date' => 'date',
        'description' => 'string',
        'visible_to_person' => 'boolean',
    ];

    public static $rules = [
        'title' => 'required',
        'date' => 'required',
        'attachment' => 'nullable|mimes:jpeg,png,pdf,docx,doc',
    ];

    protected $appends = ['ipd_timeline_document_url'];

    public function getIpdTimelineDocumentUrlAttribute()
    {
        $media = $this->media->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return '';
    }

    public function scopeVisible($query)
    {
        return $query->where('visible_to_person', 1);
    }
}
