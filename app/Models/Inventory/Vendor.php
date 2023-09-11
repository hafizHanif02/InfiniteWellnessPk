<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'manufacturer_id',
        'account_title',
        'contact_person',
        'phone',
        'email',
        'address',
        'ntn',
        'sales_tax_reg',
        'active',
        'area',
        'city'
    ];

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }
}
