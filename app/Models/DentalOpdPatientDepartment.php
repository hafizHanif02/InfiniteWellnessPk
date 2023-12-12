<?php

namespace App\Models;

use Str;
use App\Models\Doctor;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DentalOpdPatientDepartment extends Model
{


    const PAYMENT_MODES = [
        1 => 'Cash',
        2 => 'Cheque',
        3 => 'Card',
    ];

    public $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_id',
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
        'followup_charge',
        'total_amount',
        'advance_amount',
        'payment_mode',
        'currency_symbol',
        'service_id'
    ];

    /**
     * Validation rules
     *
     * @var array
     */


    /**
     * @var array
     */
    protected $appends = ['payment_mode_name'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */


    /**
     * @return BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }


    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }


    /**
     * @return BelongsTo
     */
    public function patientCase()
    {
        return $this->belongsTo(PatientCase::class, 'case_id');
    }


    /**
     * @return string
     */
    public static function generateUniqueOpdNumber()
    {
        $opdNumber = strtoupper(Str::random(8));
        $opdNumber = Carbon::now()->format('Y') . '-'.random_int(10000, 99999);
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
