<?php

namespace App\Models\Purchase;

use App\Models\Batch;
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
        'manufacturer_retail_price',
        'batch_id',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function goodReceiveNote(): BelongsTo
    {
        return $this->belongsTo(GoodReceiveNote::class);
    }

    public function requistionProduct(): BelongsTo
    {
        return $this->belongsTo(RequistionProduct::class,'product_id','product_id');
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class,'batch_id','id');
    }
}
