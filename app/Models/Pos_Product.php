<?php

namespace App\Models;

use App\Models\Pos;
use App\Models\BatchPOS;
use App\Models\Medicine;
use App\Models\PosProductReturn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pos_Product extends Model
{
    use HasFactory;
    public $fillable = [
        'pos_id',
        'medicine_id',
        'product_name',
        'batch_id',
        'generic_formula',
        'product_quantity',
        'mrp_perunit',
        'gst_percentage',
        'gst_amount',
        'discount_percentage',
        'discount_amount',
        'product_total_price',
        'user_id',

    ];


    public function medicine(): HasOne
    {
        return $this->HasOne(Medicine::class, 'id', 'medicine_id');
    }
    
    public function batchpos(): HasOne
    {
        return $this->HasOne(BatchPOS::class, 'id', 'batch_id');
    }

    public function label(): BelongsTo
    {
        return $this->belongsTo(Label::class, 'medicine_id', 'pos_id');
    }
    public function pos() : BelongsTo
{
    return $this->belongsTo(Pos::class , 'pos_id', 'id'); 
}

}
