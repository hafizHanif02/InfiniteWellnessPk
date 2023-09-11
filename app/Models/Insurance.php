<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Insurance extends Model
{
    public static $rules = [
        'name' => 'required|unique:insurances,name',
        'service_tax' => 'required',
        'insurance_no' => 'required',
        'insurance_code' => 'required',
        'hospital_rate' => 'required',
        'discount' => 'required|integer',
    ];

    /**
     * @var string
     */
    public $table = 'insurances';

    const STATUS_ALL = 2;

    const ACTIVE = 1;

    const INACTIVE = 0;

    const STATUS_ARR = [
        self::STATUS_ALL => 'All',
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Deactive',
    ];

    const FILTER_STATUS_ARRAY = [
        0 => 'All',
        1 => 'Active',
        2 => 'Deactive',
    ];

    public $fillable = [
        'name',
        'service_tax',
        'discount',
        'remark',
        'insurance_no',
        'insurance_code',
        'hospital_rate',
        'total',
        'status',
    ];

    protected $casts = [
        'id' => 'integer',
        'service_tax' => 'integer',
        'discount' => 'integer',
        'remark' => 'string',
        'insurance_no' => 'string',
        'insurance_code' => 'string',
        'hospital_rate' => 'double',
        'total' => 'double',
        'status' => 'integer',
        'name' => 'string',
    ];

    public function insuranceDiseases(): HasMany
    {
        return $this->hasMany(InsuranceDisease::class);
    }
}
