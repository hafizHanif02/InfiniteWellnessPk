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
        'product_quantity',
        'product_total_price',

    ];


    public function medicine(): HasOne
    {
        return $this->HasOne(Medicine::class, 'id', 'medicine_id');
    }
}
