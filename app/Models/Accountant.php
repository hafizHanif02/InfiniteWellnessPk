<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Accountant extends Model
{
    public $fillable = [
        'user_id',
    ];

    const STATUS_ALL = 2;

    const ACTIVE = 1;

    const INACTIVE = 0;

    const STATUS_ARR = [
        self::STATUS_ALL => 'All',
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Deactive',
    ];

    const FILTER_STATUS_ARR = [
        0 => 'All',
        1 => 'Active',
        2 => 'Deactive',
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
    ];

    public static $rules = [
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|email:filter|unique:users,email',
        'password' => 'nullable|same:password_confirmation|min:6',
        'designation' => 'required|string',
        'qualification' => 'required|string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'owner');
    }

    public function payrolls(): MorphMany
    {
        return $this->morphMany(EmployeePayroll::class, 'owner');
    }
}
