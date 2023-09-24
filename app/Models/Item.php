<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    public static $rules = [
        'name' => 'required|unique:items,name',
        'itemcategory_id' => 'required',
        'unit' => 'required',
        'description' => 'nullable',
    ];

    public $fillable = [
        'name',
        'itemcategory_id',
        'unit',
        'description',
        'available_quantity',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'itemcategory_id' => 'integer',
        'unit' => 'integer',
        'description' => 'string',
        'available_quantity' => 'integer',
    ];

    public function itemcategory(): BelongsTo
    {
        return $this->belongsTo(ItemCategory::class);
    }
}
