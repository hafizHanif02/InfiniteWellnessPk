<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    public static $rules = [
        'name' => 'required|unique:items,name',
        'item_category_id' => 'required',
        'unit' => 'required',
        'description' => 'nullable',
    ];

    public $fillable = [
        'name',
        'item_category_id',
        'unit',
        'description',
        'available_quantity',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'item_category_id' => 'integer',
        'unit' => 'integer',
        'description' => 'string',
        'available_quantity' => 'integer',
    ];

    public function itemcategory(): BelongsTo
    {
        return $this->belongsTo(ItemCategory::class);
    }
}
