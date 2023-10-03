<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyChain extends Model
{
    use HasFactory;

    protected $table = 'supply_chain';

    public $fillable = [
         'user_id'
    ];
}
