<?php

namespace App\Models;

use Eloquent as Model;

class BloodBank extends Model
{
    public $fillable = [
        'blood_group',
        'remained_bags',
    ];

    protected $casts = [
        'id' => 'integer',
        'blood_group' => 'string',
        'remained_bags' => 'integer',
    ];

    public static $rules = [
        'blood_group' => 'required|unique:blood_banks,blood_group',
        'remained_bags' => 'required|numeric',
    ];
}
