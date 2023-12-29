<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Purchase\GoodReceiveNote;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GrnPayment extends Model
{
    use HasFactory;
    protected $table = 'grn_payments';
    protected $fillable = ['grn_id','paid_amount','paid_date','created_by','updated_by'];

    public function grn(): BelongsTo
    {
        return $this->belongsTo(GoodReceiveNote::class,'grn_id','id');
    }
}
