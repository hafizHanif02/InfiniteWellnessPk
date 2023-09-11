<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    public $fillable = [
        'name', 'is_active',
    ];

    const STATUS_ALL = 2;

    const ACTIVE = 1;

    const INACTIVE = 0;

    const STATUS_ARR = [
        self::STATUS_ALL => 'All',
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Deactive',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
        'id' => 'integer',
        'name' => 'string',
        'is_active' => 'integer',
    ];

    public static $rules = [
        'name' => 'required|unique:categories,name',
    ];

    public function medicines(): HasMany
    {
        return $this->hasMany(Medicine::class, 'category_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
