<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ambulance extends Model
{
    const STATUS_ALL = 2;

    const TRUE = 1;

    const FALSE = 0;

    const STATUS_ARR = [
        self::STATUS_ALL => 'All',
        self::TRUE => 'Available',
        self::FALSE => 'Not Available',
    ];

    const FILTER_STATUS_ARR = [
        0 => 'All',
        1 => 'Available',
        2 => 'Not Available',
    ];

    public static $vehicleType = [
        2 => 'Owned',
        1 => 'Contractual',
    ];

    public static $rules = [
        'vehicle_number' => 'required|unique:ambulances,vehicle_number',
        'vehicle_model' => 'required',
        'driver_contact' => 'nullable|numeric',
        'year_made' => 'required|size:4',
        'driver_name' => 'required|string',
        'driver_license' => 'required|string',
    ];

    public $fillable = [
        'vehicle_number',
        'vehicle_model',
        'year_made',
        'driver_name',
        'driver_license',
        'driver_contact',
        'is_available',
        'note',
        'vehicle_type',
    ];

    protected $casts = [
        'id' => 'integer',
        'vehicle_number' => 'string',
        'vehicle_model' => 'string',
        'year_made' => 'string',
        'driver_name' => 'string',
        'driver_license' => 'string',
        'driver_contact' => 'string',
        'note' => 'string',
        'vehicle_type' => 'integer',
        'is_available' => 'boolean',
    ];
}
