<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    public $appends = ['type_label'];

    public $fillable = [
        'name',
        'type',
        'description',
        'status',
    ];

    const INACTIVE = 0;

    const ACTIVE = 1;

    const ACTIVE_ALL = 2;

    const STATUS_ARR = [
        self::ACTIVE_ALL => 'All',
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Deactive',
    ];

    const FILTER_STATUS_ARR = [
        0 => 'All',
        1 => 'Active',
        2 => 'Deactive',
    ];

    const DEBIT = 1;

    const CREDIT = 2;

    const TYPE_ALL = 0;

    const TYPE_ARR = [
        self::TYPE_ALL => 'All',
        self::DEBIT => 'Debit',
        self::CREDIT => 'Credit',
    ];

    const ACCOUNT_TYPES = [
        self::TYPE_ALL => 'All',
        self::CREDIT => 'Credit',
        self::DEBIT => 'Debit',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'status' => 'boolean',
        'type' => 'integer',
    ];

    public static $rules = [
        'name' => 'required|string|unique:accounts,name',
        'type' => 'required|integer',
        'status' => 'nullable|integer',
        'description' => 'string|nullable',
    ];

    public function getTypeLabelAttribute()
    {
        return ($this->type > 1) ? self::TYPE_ARR[self::CREDIT] : self::TYPE_ARR[self::DEBIT];
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
