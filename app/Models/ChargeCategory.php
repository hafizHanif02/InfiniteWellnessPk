<?php

namespace App\Models;

use Eloquent as Model;

class ChargeCategory extends Model
{
    const CHARGE_TYPES = [
        1 => 'Investigations',
        2 => 'Operation Theatre',
        3 => 'Others',
        4 => 'Procedures',
        5 => 'Supplier',
        6 => 'Dental',
    ];

    const FILTER_CHARGE_TYPES = [
        0 => 'All',
        6 => 'Dental',
        4 => 'Procedures',
        1 => 'Investigations',
        5 => 'Supplier',
        2 => 'Operation Theatre',
        3 => 'Others',
    ];

    public $fillable = [
        'name',
        'description',
        'charge_type',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'charge_type' => 'string',
    ];

    public static $rules = [
        'name' => 'required|unique:charge_categories,name',
        'description' => 'nullable|string',
        'charge_type' => 'required',
    ];
}
