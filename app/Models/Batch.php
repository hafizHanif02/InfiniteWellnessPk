<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $table = 'batch';
    use HasFactory;
    protected $fillable = [
        'batch_no',  
        'product_id',
        'unit_trade',
        'unit_retail',
        'quantity',
        'transfer_quantity',
        'remaining_qty',
        'expiry_date'
    ];
}
