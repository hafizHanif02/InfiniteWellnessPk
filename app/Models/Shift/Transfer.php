<?php

namespace App\Models\Shift;

use App\Models\Shift\TransferProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'supply_date',
        'status',
    ];

    public function transferProducts(): HasMany
    {
        return $this->hasMany(TransferProduct::class,'transfer_id');
    }
}
