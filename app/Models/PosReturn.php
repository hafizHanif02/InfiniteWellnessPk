<?php

namespace App\Models;

use App\Models\PosProductReturn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PosReturn extends Model
{
    use HasFactory;
    
    public $fillable = [
        'pos_id',
        'total_amount',
    ];



    public function Pos_Product_Return(): HasMany
    {
        return $this->hasMany(PosProductReturn::class,'pos_id');
    }
}
