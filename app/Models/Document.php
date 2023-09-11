<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Document extends Model implements HasMedia
{
    use InteractsWithMedia;

    public const PATH = 'documents';

    public $fillable = [
        'title',
        'document_type_id',
        'patient_id',
        'uploaded_by',
        'notes',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'document_type_id' => 'integer',
        'patient_id' => 'integer',
        'uploaded_by' => 'integer',
        'notes' => 'string',
    ];

    public static $rules = [
        'title' => 'required|string',
        'document_type_id' => 'required|integer',
        'patient_id' => 'required|integer',
    ];

    protected $appends = ['document_url'];

    public function getDocumentUrlAttribute()
    {
        $media = $this->media->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return '';
    }

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function prepareDocument(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title ?? 'N/A',
            'document_type_id' => $this->document_type_id ?? 'N/A',
            'patient_id' => $this->patient_id ?? 'N/A',
            'uploaded_by' => $this->uploaded_by ?? 'N/A',
            'notes' => $this->notes ?? 'N/A',
            'is_default' => $this->is_default ?? 'N/A',
            'document_url' => $this->document_url ?? 'N/A',
        ];
    }
}
