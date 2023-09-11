<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Str;

class Bed extends Model
{
    public $fillable = [
        'bed_type',
        'bed_id',
        'description',
        'name',
        'charge',
        'is_available',
        'currency_symbol',
    ];

    protected $casts = [
        'id' => 'integer',
        'bed_type' => 'integer',
        'bed_id' => 'string',
        'description' => 'string',
        'name' => 'string',
        'charge' => 'integer',
        'is_available' => 'integer',
        'currency_symbol' => 'string',
    ];

    const NOTAVAILABLE = 0;

    const AVAILABLE = 1;

    const AVAILABLE_ALL = 2;

    const STATUS_ARR = [
        self::AVAILABLE_ALL => 'All',
        self::AVAILABLE => 'Available',
        self::NOTAVAILABLE => 'Not Available',
    ];

    const FILTER_INCOME_HEAD = [
        0 => 'All',
        1 => 'Available',
        2 => 'Not Available',
    ];

    public static $rules = [
        'bed_type' => 'required',
        'name' => 'required|unique:beds,name',
        'charge' => 'required',
        'description' => 'string|nullable',
    ];

    public function patientNameRetrieved()
    {
        foreach ($this->bedAssigns as $bedAssign) {
            return $bedAssign->patient->patientUser->full_name;
        }
    }

    public function prepareData(): array
    {
        return [
            'bed_type' => $this->bed_type,
            'patient_name' => $this->patientNameRetrieved() ?? 'N/A',
        ];
    }

    public function prepareBedAssignData(): array
    {
        return [
            'bed_name' => $this->name,
            'patient' => $this->bedAssigns[0]->patient->patientUser->full_name ?? 'N/A',
            'phone' => $this->bedAssigns[0]->patient->patientUser->phone ?? 'N/A',
            'admission_date' => date('jS M, Y h:i A', strtotime($this->bedAssigns[0]->assign_date)) ?? 'N/A',
            'gender' => $this->bedAssigns[0]->patient->patientUser->gender ? 'Female' : 'Male' ?? 'N/A',
        ];
    }

    public function preparePatientAdmissionData()
    {
        return $this->patientAdmission[0]->prepareData();
    }

    public static function generateUniqueBedId(): string
    {
        $bedId = Str::random(8);
        while (true) {
            $isExist = self::whereBedId($bedId)->exists();
            if ($isExist) {
                self::generateUniqueBedId();
            }
            break;
        }

        return $bedId;
    }

    public function bedType(): BelongsTo
    {
        return $this->belongsTo(BedType::class, 'bed_type');
    }

    public function patientAdmission(): HasMany
    {
        return $this->hasMany(PatientAdmission::class);
    }

    public function bedAssigns(): HasMany
    {
        return $this->hasMany(BedAssign::class);
    }
}
