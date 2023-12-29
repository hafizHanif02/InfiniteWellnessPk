<?php

namespace App\Models;

use App\Models\Batch;
use App\Models\Inventory\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BatchPOS extends Model
{
    protected $table = 'batch_pos';
    use HasFactory;
    protected $fillable = [
        'batch_id',  
        'product_id',
        'unit_trade',
        'unit_retail',
        'quantity',
        'sold_quantity',
        'remaining_qty',
        'expiry_date',
    ];


    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class,'batch_id','id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
