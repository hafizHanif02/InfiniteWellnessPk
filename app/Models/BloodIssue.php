<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BloodIssue extends Model
{
    public $fillable = [
        'issue_date',
        'doctor_id',
        'patient_id',
        'donor_id',
        'amount',
        'remarks',
        'currency_symbol',
    ];

    public static $rules = [
        'issue_date' => 'required',
        'patient_id' => 'required',
        'doctor_id' => 'required',
        'donor_id' => 'required',
        'remarks' => 'string|nullable',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'patient_id' => 'integer',
        'doctor_id' => 'integer',
        'donor_id' => 'integer',
        'amount' => 'integer',
        'remarks' => 'string',
        'currency_symbol' => 'string',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function blooddonor(): BelongsTo
    {
        return $this->belongsTo(BloodDonor::class, 'donor_id');
    }
}
