<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'group_id',
        'generic_id',
        'package_detail',
        'product_category_id',
        'manufacturer_id',
        'vendor_id',
        'least_unit',
        'manufacturer_retail_price',
        'number_of_pack',
        'pieces_per_pack',
        'packing',
        'trade_price_percentage',
        'unit_retail',
        'fixed_discount',
        'trade_price',
        'unit_trade',
        'sale_tax',
        'discount_trade_price',
        'cost_price',
        'barcode',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
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
}
