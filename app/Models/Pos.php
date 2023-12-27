<?php

namespace App\Models;

use App\Models\Pos;
use App\Models\Pos_Product;
use App\Models\PosProductReturn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pos extends Model
{
    public $fillable = [
        'prescription_id',
        'total_amount',
        'pos_fees',
        'fbr_invoice_no',
        'total_discount',
        'total_saletax',
        'total_amount_ex_saletax',
        'total_amount_inc_saletax',
        'patient_name',
        'patient_number',
        'patient_mr_number',
        'doctor_name',
        'cashier_name',
        'pos_date',
        'is_paid',
        'is_cash',
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

    public function PosProductReturn()
    {
        return $this->hasMany(PosProductReturn::class,'pos_id');
    }
    public function scopeFilter($query, $request): void
    {
        if (isset($request->is_cash)) {
            $query->where('is_cash', $request->is_cash);
        }
        if ($request->date_from && $request->date_to) {
            $query->whereBetween('pos_date', [$request->date_from, $request->date_to]);
        } elseif ($request->date_from) {
            $query->where('pos_date', '>=', $request->date_from);
        } elseif ($request->date_to) {
            $query->where('pos_date', '<=', $request->date_to);
        }
        if (isset($request->is_paid)) {
            $query->where('is_paid', $request->is_paid);
        }
    }
}
