<?php

namespace App\Models;

use Eloquent as Model;

class ItemCategory extends Model
{
    public static $rules = [
        'name' => 'required|unique:item_categories,name',
    ];

    public $fillable = [
        'name',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
    ];
}
