<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FastMedicalRecord extends Model
{
    use HasFactory;
    protected $table = "fast_medical_records";

    protected $fillable = [
        'patient_name',
        'referred_by',
        'dob',
        'contact',
        'referrel_date',
        'pre_test_date',
        'pre_test_status',
        'blood_collection_date',
        'blood_collection_amount',
        'blood_collection_status',
        'date_of_shipment',
        'fast_test_report_date',
        'fast_test_report_status',
        'report_session_date',
        'report_session_status',
        'post_test_consult_date',
        'post_test_consult_status',
        'post_post_test_date',
        'post_post_test_status',
        'retest_date',
        'retest_date_status',
        'dietitian',
        'comment',
    ];
}
