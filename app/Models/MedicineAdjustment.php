<?php

namespace App\Models;

use App\Models\BatchPOS;
use App\Models\Medicine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicineAdjustment extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "medicine_id",
        "batchPOS_id",
        "medicine_name",
        "current_qty",
        "adjustment_qty",
        "different_qty",
        "created_at",
        "updated_at",
        ]; 

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function batchPOS()
    {
        return $this->belongsTo(BatchPOS::class, 'batchPOS_id');
    }
}
