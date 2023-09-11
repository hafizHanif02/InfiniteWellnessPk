<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IpdPrescriptionItem extends Model
{
    public $fillable = [
        'ipd_prescription_id',
        'category_id',
        'medicine_id',
        'dosage',
        'instruction',
    ];

    protected $casts = [
        'id' => 'integer',
        'ipd_prescription_id' => 'integer',
        'category_id' => 'integer',
        'medicine_id' => 'integer',
        'dosage' => 'string',
        'instruction' => 'string',
    ];

    public static $rules = [
        'category_id' => 'required',
    ];

    public function medicineCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }
}
