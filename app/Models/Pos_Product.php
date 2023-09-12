<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pos_Product extends Model
{
    use HasFactory;
    public $fillable = [
        'pos_id',
        'product_id',
        'product_quantity',
        'product_total_price',

    ];
}
