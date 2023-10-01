<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allergies extends Model
{
    use HasFactory;
    protected $fillable = [
        'nursing_form_id',
        'patient_mr_number',
        'allergen',
        'reaction',
        'severity',
    ];
}
