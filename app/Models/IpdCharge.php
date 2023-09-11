<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IpdCharge extends Model
{
    const  CHARGE_TYPES = [
        1 => 'Investigations',
        2 => 'Operation Theatre',
        3 => 'Others',
        4 => 'Procedures',
        5 => 'Supplier',
    ];

    public $fillable = [
        'ipd_patient_department_id',
        'date',
        'charge_type_id',
        'charge_category_id',
        'charge_id',
        'standard_charge',
        'applied_charge',
        'currency_symbol',
    ];

    protected $casts = [
        'id' => 'integer',
        'ipd_patient_department_id' => 'integer',
        'date' => 'date',
        'charge_type_id' => 'integer',
        'charge_category_id' => 'integer',
        'charge_id' => 'integer',
        'standard_charge' => 'integer',
        'applied_charge' => 'integer',
        'currency_symbol' => 'string',
    ];

    public static $rules = [
        'date' => 'required',
        'charge_type_id' => 'required',
        'charge_category_id' => 'required',
        'charge_id' => 'required',
        'applied_charge' => 'required',
    ];

    protected $appends = ['charge_type'];

    public function chargecategory(): BelongsTo
    {
        return $this->belongsTo(ChargeCategory::class);
    }

    public function charge(): BelongsTo
    {
        return $this->belongsTo(Charge::class);
    }

    public function getChargeTypeAttribute()
    {
        return self::CHARGE_TYPES[$this->charge_type_id];
    }
}
