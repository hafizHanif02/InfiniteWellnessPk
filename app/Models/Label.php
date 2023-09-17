<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'pos_id',
        'medicine_id',
        'patient_id',
        'name',
        'brand_name',
        'quantity',
        'date_of_selling',
        'patient_name',
        'direction_use',
        'common_side_effect',

    ];
}
