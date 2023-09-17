<?php

namespace App\Models;

use App\Models\Pos;
use App\Models\Pos_Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pos extends Model
{
    public $fillable = [
        'prescription_id',
        'total_amount',
        'pos_fees',
        'total_discount',
        'total_saletax',
        'total_amount_ex_saletax',
        'total_amount_inc_saletax',
        'patient_name',
        'doctor_name',
        'pos_date',
        'is_paid',
        'enter_payment_amount',
        'change_amount'

    ];

    public function prescription(): BelongsTo
    {
        return $this->belongsTo(Prescription::class);
    }
    public function PosProduct()
    {
        return $this->hasMany(Pos_Product::class,'pos_id');
    }
}
