<?php

namespace App\Models\Purchase;

use App\Models\Inventory\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseReturnNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'good_receive_note_id',
        'product_id',
        'quantity',
        'price',
        'status',
        'remark',
    ];

    public function goodReceiveNote(): BelongsTo
    {
        return $this->belongsTo(GoodReceiveNote::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
