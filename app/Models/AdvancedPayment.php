<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdvancedPayment extends Model
{
    public $fillable = [
        'patient_id',
        'receipt_no',
        'amount',
        'date',
        'currency_symbol',
    ];

    protected $casts = [
        'id' => 'integer',
        'patient_id' => 'integer',
        'receipt_no' => 'string',
        'amount' => 'double',
        'date' => 'date',
        'currency_symbol' => 'string',
    ];

    public static $rules = [
        'patient_id' => 'required',
        'receipt_no' => 'required|string',
        'amount' => 'required',
        'date' => 'required|date',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
