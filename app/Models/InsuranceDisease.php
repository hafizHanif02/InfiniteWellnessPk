<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsuranceDisease extends Model
{
    public static $rules = [
        'insurance_id' => 'required',
        'disease_name' => 'required',
        'disease_charge' => 'required',
    ];

    public $fillable = [
        'insurance_id',
        'disease_name',
        'disease_charge',
    ];

    protected $casts = [
        'id' => 'integer',
        'disease_name' => 'string',
        'disease_charge' => 'integer',
    ];
}
