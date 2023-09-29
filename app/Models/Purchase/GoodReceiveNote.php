<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoodReceiveNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'requistion_id',
        'remark',
        'date',
        'total_amount',
        'total_discount_amount',
        'net_total_amount',
        'advance_tax_percentage',
        'advance_tax_amount',
        'sale_tax_percentage',
        'is_approved',
    ];

    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? date('d-m-Y',strtotime($value)) : null,
        );
    }

    public function requistion(): BelongsTo
    {
        return $this->belongsTo(Requistion::class);
    }

    public function goodReceiveProducts(): HasMany
    {
        return $this->hasMany(GoodReceiveProduct::class);
    }
}
