<?php

namespace App\Models;

use App\Models\Medicine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pos_Product extends Model
{
    use HasFactory;
    public $fillable = [
        'pos_id',
        'medicine_id',
        'product_name',
        'generic_formula',
        'product_quantity',
        'mrp_perunit',
        'gst_percentage',
        'gst_amount',
        'discount_percentage',
        'discount_amount',
        'product_total_price',

    ];


    public function medicine(): HasOne
    {
        return $this->HasOne(Medicine::class, 'id', 'medicine_id');
    }
}
