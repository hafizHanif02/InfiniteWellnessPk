<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IssuedItem extends Model
{
    public const ITEM_RETURN = 0;

    public const ITEM_RETURNED = 1;

    const STATUS_ALL = 2;

    public const STATUS_ARR = [
        self::STATUS_ALL => 'All',
        self::ITEM_RETURN => 'Return Item',
        self::ITEM_RETURNED => 'Returned',
    ];

    public static $rules = [
        'department_id' => 'required',
        'user_id' => 'required',
        'issued_by' => 'required',
        'issued_date' => 'required',
        'return_date' => 'nullable',
        'itemcategory_id' => 'required',
        'item_id' => 'required',
        'quantity' => 'required',
        'description' => 'nullable',
        'status' => 'nullable',
    ];

    public $fillable = [
        'department_id',
        'user_id',
        'issued_by',
        'issued_date',
        'return_date',
        'itemcategory_id',
        'item_id',
        'quantity',
        'description',
        'status',
    ];

    protected $casts = [
        'id' => 'integer',
        'department_id' => 'integer',
        'user_id' => 'integer',
        'issued_by' => 'string',
        'issued_date' => 'date',
        'return_date' => 'date',
        'itemcategory_id' => 'integer',
        'item_id' => 'integer',
        'quantity' => 'integer',
        'description' => 'string',
        'status' => 'boolean',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
