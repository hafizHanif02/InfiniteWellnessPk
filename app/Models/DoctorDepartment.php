<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DoctorDepartment extends Model
{
    public $fillable = [
        'title',
        'short_name',
        'description',
    ];

    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'short_name' => 'string',
        'description' => 'string',
    ];

    public static $rules = [
        'title' => 'required|unique:doctor_departments,title',
        'short_name' => 'required',
    ];

    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class,'department_id');
    }
}
