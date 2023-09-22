<?php

namespace App\Models;

use App\Models\Pos;
use App\Models\PosProductReturn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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



    public function scopeFilter($query, $request)
    {
        return $request;
        if ($request->pos->is_cash) {
            $query->pos->where('is_cash', $request->is_cash);
        }
        if ($request->pos->date_from && $request->date_to) {
            $query->pos->whereBetween('pos_date', [$request->date_from, $request->date_to]);
        } elseif ($request->date_from) {
            $query->pos->where('pos_date', '>=', $request->date_from);
        } elseif ($request->date_to) {
            $query->pos->where('pos_date', '<=', $request->date_to);
        }
    }


}
