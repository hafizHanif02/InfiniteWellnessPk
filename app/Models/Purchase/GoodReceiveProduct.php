<?php

namespace App\Models\Purchase;

use App\Models\Inventory\Product;
use Illuminate\Database\Eloquent\Model;
use App\Models\Purchase\RequistionProduct;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoodReceiveProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'good_receive_note_id',
        'product_id',
        'deliver_qty',
        'bonus',
        'expiry_date',
        'item_amount',
        'batch_number',
        'discount',
        'saletax_percentage',
        'saletax_amount',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function goodReceiveNote(): BelongsTo
    {
        return $this->belongsTo(GoodReceiveNote::class);
    }

    public function requistionProducts(): HasOne
    {
        return $this->hasOne(RequistionProduct::class,'product_id','product_id');
    }
}
