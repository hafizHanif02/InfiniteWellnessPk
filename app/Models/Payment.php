<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    public $fillable = [
        'payment_date',
        'account_id',
        'pay_to',
        'currency_symbol',
        'description',
        'amount',
    ];

    protected $casts = [
        'id' => 'integer',
        'account_id' => 'integer',
        'pay_to' => 'string',
        'payment_date' => 'date',
        'currency_symbol' => 'string',
        'description' => 'string',
        'amount' => 'string',
    ];

    public static $rules = [
        'payment_date' => 'required',
        'account_id' => 'required',
        'pay_to' => 'required',
        'amount' => 'required',
        'description' => 'nullable|string',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function accounts(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
