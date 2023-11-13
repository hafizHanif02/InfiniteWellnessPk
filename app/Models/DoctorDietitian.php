<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorDietitian extends Model
{
    use HasFactory;
    protected $table = 'doctor_dietitian';

    public $fillable = [
         'user_id'
    ];
}
