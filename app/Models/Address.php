<?php

namespace App\Models;

use Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends Model
{
    protected $fillable = [
        'owner_id',
        'owner_type',
        'address1',
        'address2',
        'city',
        'zip',
    ];

    protected $casts = [
        'owner_id' => 'integer',
        'owner_type' => 'string',
        'address1' => 'string',
        'address2' => 'string',
        'city' => 'string',
        'zip' => 'string',
    ];

    public function owner(): MorphTo
    {
        return $this->morphTo();
    }

    public static function prepareAddressArray($input)
    {
        return Arr::only(array_filter($input), [
            'address1',
            'address2',
            'city',
            'zip',
        ]);
    }
}
