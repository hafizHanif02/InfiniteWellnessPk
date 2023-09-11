<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IpdPrescription extends Model
{
    public $fillable = [
        'ipd_patient_department_id',
        'header_note',
        'footer_note',
    ];

    protected $casts = [
        'id' => 'integer',
        'ipd_patient_department_id' => 'integer',
        'header_note' => 'string',
        'footer_note' => 'string',
    ];

    public static $rules = [
        'date' => 'nullable',
        'charge_type_id' => 'nullable',
        'category_id' => 'required',
    ];

    public function ipdPrescriptionItems(): HasMany
    {
        return $this->hasMany(IpdPrescriptionItem::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(IpdPatientDepartment::class);
    }
}
