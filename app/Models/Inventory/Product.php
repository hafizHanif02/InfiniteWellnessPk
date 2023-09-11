<?php

namespace App\Models\Inventory;

use App\Models\Purchase\GoodReceiveProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_category_id',
        'dosage_id',
        'generic_id',
        'package_detail',
        'product_category_id',
        'manufacturer_id',
        'vendor_id',
        'unit_of_measurement',
        'manufacturer_retail_price',
        'number_of_pack',
        'pieces_per_pack',
        'total_quantity',
        'trade_price_percentage',
        'unit_retail',
        'fixed_discount',
        'trade_price',
        'unit_trade',
        'sale_tax_percentage',
        'discount_trade_price',
        'cost_price',
        'barcode',
    ];

    public function dosage(): BelongsTo
    {
        return $this->belongsTo(Dosage::class);
    }

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function generic(): BelongsTo
    {
        return $this->belongsTo(Generic::class);
    }

    public function goodReceiveProducts(): HasMany
    {
        return $this->hasMany(GoodReceiveProduct::class);
    }
}
