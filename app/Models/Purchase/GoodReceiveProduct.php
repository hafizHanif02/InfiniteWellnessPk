<?php

namespace App\Models\Purchase;

use App\Models\Inventory\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function goodReceiveNote(): BelongsTo
    {
        return $this->belongsTo(GoodReceiveNote::class);
    }
}
