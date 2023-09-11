<?php

namespace App\Models\Shift;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'supply_date',
        'status',
    ];

    public function transferProducts(): HasMany
    {
        return $this->hasMany(TransferProduct::class);
    }
}
