<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiagnosisCategory extends Model
{
    public $fillable = [
        'name',
        'description',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
    ];

    public static $rules = [
        'name' => 'required|unique:diagnosis_categories,name',
    ];
}
