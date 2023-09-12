<?php

namespace App\Models\Purchase;

use App\Models\Inventory\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequistionProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'requistion_id',
        'product_id',
        'limit',
        'price_per_unit',
        'total_piece',
        'discount_percentage',
        'total_amount',
        'is_approved',
    ];

    public function requistion(): BelongsTo
    {
        return $this->belongsTo(Requistion::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
