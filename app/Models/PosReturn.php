<?php

namespace App\Models;

use App\Models\Pos;
use App\Models\PosProductReturn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PosReturn extends Model
{
    use HasFactory;
    
    public $fillable = [
        'pos_id',
        'total_amount',
    ];



    

    public function Pos_Product_Return()
    {
        return $this->hasMany(PosProductReturn::class,'pos_return_id');
    }
    
    public function Pos(): BelongsTo
    {
        return $this->BelongsTo(Pos::class);
    }
}
