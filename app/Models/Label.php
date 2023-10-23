<?php

namespace App\Models;

use App\Models\Pos;
use App\Models\Medicine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function pos(): BelongsTo
    {
        return $this->belongsTo(Pos::class);
    }

    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class,'medicine_id');
    }
}
