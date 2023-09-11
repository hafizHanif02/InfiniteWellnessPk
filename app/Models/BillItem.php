<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BillItem extends Model
{
    public $fillable = [
        'item_name',
        'bill_id',
        'qty',
        'price',
        'amount',
    ];

    protected $casts = [
        'id' => 'integer',
        'item_name' => 'string',
        'bill_id' => 'integer',
        'qty' => 'integer',
        'price' => 'double',
        'amount' => 'double',
    ];

    public static $rules = [
        'item_name' => 'required|string',
        'qty' => 'required|integer',
        'price' => 'required|regex:/^\d*(\.\d{1,2})?$/',
    ];

    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }
}
