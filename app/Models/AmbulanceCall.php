<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AmbulanceCall extends Model
{
    public static $rules = [
        'patient_id' => 'required|integer|min:1',
        'date' => 'required|string',
        'amount' => 'required|numeric',
    ];

    public static $messages = [
        'min' => 'Please select at least one patient.',
    ];

    public $table = 'ambulance_calls';

    public $fillable = [
        'ambulance_id',
        'patient_id',
        'driver_name',
        'date',
        'amount',
        'currency_symbol',
    ];

    protected $casts = [
        'id' => 'integer',
        'patient_id' => 'integer',
        'ambulance_id' => 'integer',
        'driver_name' => 'string',
        'date' => 'datetime',
        'amount' => 'real',
        'currency_symbol' => 'string',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function ambulance(): BelongsTo
    {
        return $this->belongsTo(Ambulance::class);
    }

    public function setBillDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}
