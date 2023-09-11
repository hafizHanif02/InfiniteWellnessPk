<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class CaseHandler extends Model
{
    public static $rules = [
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'password' => 'nullable|same:password_confirmation|min:6',
        'designation' => 'required|string',
        'qualification' => 'required|string',
        'address1' => 'nullable|string',
        'address2' => 'nullable|string',
        'city' => 'nullable|string',
        'zip' => 'nullable|integer',
    ];

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

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
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
