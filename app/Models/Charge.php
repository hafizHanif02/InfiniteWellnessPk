<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Charge extends Model
{
    public $fillable = [
        'charge_type',
        'charge_category_id',
        'code',
        'standard_charge',
        'description',
        'currency_symbol',
    ];

    protected $casts = [
        'id' => 'integer',
        'charge_type' => 'integer',
        'charge_category_id' => 'integer',
        'code' => 'string',
        'standard_charge' => 'string',
        'description' => 'string',
        'currency_symbol' => 'string',
    ];

    public static $rules = [
        'charge_type' => 'required',
        'charge_category_id' => 'required',
        'code' => 'required|unique:charges,code',
        'standard_charge' => 'required',
    ];

    public function chargeCategory(): BelongsTo
    {
        return $this->belongsTo(ChargeCategory::class);
    }
}
