<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BloodDonor extends Model
{
    public $fillable = [
        'name',
        'age',
        'gender',
        'blood_group',
        'last_donate_date',
        'bags',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'age' => 'integer',
        'gender' => 'integer',
        'blood_group' => 'string',
        'last_donate_date' => 'datetime',
        'bags' => 'integer',
    ];

    public static $rules = [
        'name' => 'required',
        'age' => 'required|numeric|digits_between:1,100',
        'blood_group' => 'required',
        'last_donate_date' => 'required',
    ];

    public function bloodBank(): BelongsTo
    {
        return $this->belongsTo(BloodBank::class, 'blood_group', 'blood_group');
    }
}
