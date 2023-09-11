<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BloodDonation extends Model
{
    public $fillable = [
        'blood_donor_id',
        'bags',
    ];

    public static $rules = [
        'blood_donor_id' => 'required',
        'bags' => 'required|numeric|digits_between:1,100',
    ];

    protected $casts = [
        'id' => 'integer',
        'blood_donor_id' => 'integer',
        'bags' => 'integer',
    ];

    public function blooddonor(): BelongsTo
    {
        return $this->belongsTo(BloodDonor::class);
    }
}
