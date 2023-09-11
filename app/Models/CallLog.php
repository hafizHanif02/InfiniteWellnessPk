<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CallLog extends Model
{
    const INCOMING = 1;

    const OUTCOMING = 2;

    const CALLTYPE_ARR = [
        '0' => 'All',
        '1' => 'Incoming',
        '2' => 'Outgoing',
    ];

    protected $fillable = [
        'name',
        'phone',
        'date',
        'description',
        'follow_up_date',
        'note',
        'call_type',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'phone' => 'integer',
        'date' => 'date',
        'description' => 'string',
        'follow_up_date' => 'string',
        'note' => 'string',
        'call_type' => 'integer',
    ];

    public static $rules = [
        'name' => 'required',
    ];
}
