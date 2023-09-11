<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DoctorDepartment extends Model
{
    public $fillable = [
        'title',
        'description',
    ];

    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'description' => 'string',
    ];

    public static $rules = [
        'title' => 'required|unique:doctor_departments,title',
    ];

    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class);
    }
}
