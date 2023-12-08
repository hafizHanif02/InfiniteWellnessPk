<?php

namespace App\Models;

use Carbon\Carbon;
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


    public function scopeFilter($query, $request): void
    {
        // return $request;
        if (isset($request->is_cash)) {
            $query->whereHas('pos',function ($query)use ($request) {$query->where('is_cash', $request->is_cash);});
        }
        if ($request->date_from && $request->date_to) {
            $query->whereBetween('created_at', [$request->date_from, Carbon::parse($request->date_to)->addDay()->toDateString()]);
        } elseif ($request->date_from) {
            $query->where('created_at', '>=', $request->date_from);
        } elseif ($request->date_to) {
            $query->where('created_at', '<=', Carbon::parse($request->date_to)->addDay()->toDateString());
        }
    }


}
