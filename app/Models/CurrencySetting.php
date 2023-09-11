<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CurrencySetting extends Model
{
    use HasFactory;

    public $fillable = [
        'id',
        'currency_name',
        'currency_code',
        'currency_icon',
    ];

    protected $casts = [
        'id' => 'integer',
        'currency_name' => 'string',
        'currency_code' => 'string',
        'currency_icon' => 'string',
    ];

    public static $rules = [
        'currency_name' => 'required|unique:currency_settings',
        'currency_icon' => 'required',
        'currency_code' => 'required|min:3|max:3',
    ];
}
