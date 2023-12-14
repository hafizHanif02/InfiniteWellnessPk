<?php

namespace App\Models\Shift;

use App\Models\Inventory\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransferProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'transfer_id',
        'product_id',
        'batch_id',
        'unit_of_measurement',
        'price_per_unit',
        'total_piece',
        'unit_trade',
        'total_pack',
        'amount',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function transfer(): BelongsTo
    {
        return $this->belongsTo(Transfer::class);
    }
}
