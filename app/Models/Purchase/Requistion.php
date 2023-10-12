<?php

namespace App\Models\Purchase;

use App\Models\Inventory\Vendor;
use App\Models\Inventory\Manufacturer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Requistion extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'manufacturer_id',
        'remarks',
        'delivery_date',
        'is_approved',
        'purchase_order_date',
        'discount_amount',
        'is_updated'
    ];

    protected function deliveryDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? date('d-m-Y',strtotime($value)) : null,
        );
    }
    
    protected function purchaseOrderDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? date('d-m-Y',strtotime($value)) : null,
        );
    }
    

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
    public function Manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function requistionProducts(): HasMany
    {
        return $this->hasMany(RequistionProduct::class);
    }

    public function scopeFilter($query, $request): void
    {
        if ($request->vendor_id) {
            $query->where('vendor_id', $request->vendor_id);
        }
        if ($request->date_from && $request->date_to) {
            $query->whereBetween('delivery_date', [$request->date_from, $request->date_to]);
        } elseif ($request->date_from) {
            $query->where('delivery_date', '>=', $request->date_from);
        } elseif ($request->date_to) {
            $query->where('delivery_date', '<=', $request->date_to);
        }
    }

}
