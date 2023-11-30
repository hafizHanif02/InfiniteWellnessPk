<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjustmentProduct extends Model
{
    use HasFactory;

    protected $table = 'adjustment_products';

    protected $fillable = [
        'id ',
        'product_id',
        'batch_id',
        'product_name',
        'current_qty',
        'adjustment_qty',
        'different_qty',
        'created_at',
        'updated_at',
    ];
}
