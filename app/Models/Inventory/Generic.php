<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generic extends Model
{
    use HasFactory;

    protected $fillable = [
        'formula',
        'generic_detail',
    ];
}
