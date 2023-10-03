<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorOpdCharge extends Model
{
    public $fillable = [
        'doctor_id',
        'standard_charge',
        'followup_charge',
        'currency_symbol',
    ];

    protected $casts = [
        'id' => 'integer',
        'doctor_id' => 'integer',
        'standard_charge' => 'double',
        'followup_charge' => 'double',
        'currency_symbol' => 'double',
    ];

    public static $rules = [
        'doctor_id' => 'required|unique:doctor_opd_charges,doctor_id',
        'standard_charge' => 'required',
        'followup_charge' => 'required',
    ];

    public static $messages = [
        'required.unique' => 'The doctor\'s name has already been taken.',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
