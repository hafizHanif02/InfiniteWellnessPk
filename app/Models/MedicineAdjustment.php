<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineAdjustment extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "medicine_id",
        "medicine_name",
        "current_qty",
        "adjustment_qty",
        "different_qty",
        "created_at",
        "updated_at",
        ]; 
}
