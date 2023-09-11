<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    public static $rules = [
        'account_id' => 'required|integer',
        'quantity' => 'required|integer',
        'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'description' => 'nullable|string',
    ];

    public $fillable = [
        'account_id',
        'description',
        'quantity',
        'price',
        'total',
    ];

    protected $casts = [
        'id' => 'integer',
        'account_id' => 'integer',
        'description' => 'string',
        'quantity' => 'integer',
        'price' => 'double',
        'total' => 'double',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
