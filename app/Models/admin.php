<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class admin extends Model
{
    use HasFactory;

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

    public $fillable = [
        'user_id',
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
        'image' => 'image|mimes:jpeg,jpg,png,gif',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
