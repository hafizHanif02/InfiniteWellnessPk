<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IpdConsultantRegister extends Model
{
    public $fillable = [
        'ipd_patient_department_id',
        'applied_date',
        'doctor_id',
        'instruction',
        'instruction_date',
    ];

    protected $casts = [
        'id' => 'integer',
        'ipd_patient_department_id' => 'integer',
        'applied_date' => 'date',
        'instruction_date' => 'date',
        'doctor_id' => 'integer',
        'instruction' => 'string',
    ];

    public static $rules = [
        'applied_date' => 'required',
        'instruction' => 'required',
        'instruction_date' => 'required',
    ];

    public static $messages = [
        'applied_date.required' => 'Please select applied date',
        'instruction_date.required' => 'Please select instruction date',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
