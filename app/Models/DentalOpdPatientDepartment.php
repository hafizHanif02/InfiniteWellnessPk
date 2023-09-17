<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Str;

class DentalOpdPatientDepartment extends Model
{
    public $table = 'opd_patient_departments';

    const PAYMENT_MODES = [
        1 => 'Cash',
        2 => 'Cheque',
    ];

    public $fillable = [
        'patient_id',
        'opd_number',
        'height',
        'weight',
        'bp',
        'symptoms',
        'notes',
        'appointment_date',
        'case_id',
        'is_old_patient',
        'standard_charge',
        'payment_mode',
        'currency_symbol',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'patient_id' => 'required',
        'case_id' => 'required',
        'appointment_date' => 'required',
        'doctor_id' => 'required',
        'standard_charge' => 'required',
        'payment_mode' => 'required',
        'weight' => 'numeric|max:200|nullable',
        'height' => 'numeric|max:7|nullable',
        'bp' => 'nullable|numeric|max:200',
    ];

    /**
     * @var array
     */
    protected $appends = ['payment_mode_name'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'patient_id' => 'integer',
        'opd_number' => 'string',
        'appointment_date' => 'datetime',
        'height' => 'integer',
        'weight' => 'integer',
        'bp' => 'integer',
        'symptoms' => 'string',
        'notes' => 'string',
        'case_id' => 'integer',
        'is_old_patient' => 'boolean',
        'doctor_id' => 'integer',
        'standard_charge' => 'integer',
        'payment_mode' => 'integer',
    ];

    /**
     * @return BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    /**
     * @return BelongsTo
     */
    public function patientCase()
    {
        return $this->belongsTo(PatientCase::class, 'case_id');
    }

    /**
     * @return BelongsTo
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function doctorName()
    {

        return $this->belongsTo(Doctor::class, 'doctor_id')->with('doctorUser');
    }

    /**
     * @return string
     */
    public static function generateUniqueOpdNumber()
    {
        $opdNumber = strtoupper(Str::random(8));
        while (true) {
            $isExist = self::whereOpdNumber($opdNumber)->exists();
            if ($isExist) {
                self::generateUniqueOpdNumber();
            }
            break;
        }

        return $opdNumber;
    }

    /**
     * @return mixed
     */
    public function getPaymentModeNameAttribute()
    {
        return self::PAYMENT_MODES[$this->payment_mode];
    }

}
