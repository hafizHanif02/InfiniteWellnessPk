<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    public $fillable = [
        'name',
        'email',
        'phone',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'phone' => 'string',
    ];

    public static $rules = [
        'name' => 'required|unique:brands,name',
        'email' => 'email|unique:brands,email|nullable',
        'phone' => 'nullable|numeric',
    ];

    public function medicines(): HasMany
    {
        return $this->hasMany(Medicine::class, 'brand_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
