<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Doctor extends Model
{
    public $fillable = [
        'doctor_user_id',
        'department_id',
        'specialist',
    ];

    const STATUS_ALL = 2;

    const ACTIVE = 0;

    const INACTIVE = 1;

    const STATUS_ARR = [
        self::STATUS_ALL => 'All',
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Deactive',
    ];

    protected $casts = [
        'id' => 'integer',
        'doctor_user_id' => 'integer',
        'department_id' => 'integer',
        'specialist' => 'string',
    ];

    public static $rules = [
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|email:filter|unique:users,email',
        'password' => 'nullable|same:password_confirmation|min:6',
        'designation' => 'required|string',
        'gender' => 'required',
        'qualification' => 'required|string',
        'dob' => 'nullable|date',
        'specialist' => 'required|string',
        'address1' => 'nullable|string',
        'address2' => 'nullable|string',
        'city' => 'nullable|string',
        'zip' => 'nullable|integer',
    ];

    public function prepareDoctorData(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->user->full_name,
        ];
    }

    public function doctorUser(): BelongsTo
    {
        return $this->belongsTo(User::class,'doctor_user_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'doctor_user_id');
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'owner');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(DoctorDepartment::class, 'department_id');
    }

    public function cases(): HasMany
    {
        return $this->hasMany(PatientCase::class, 'doctor_id');
    }

    public function patients(): BelongsToMany
    {
        return $this->belongsToMany(Patient::class, 'patient_cases', 'doctor_id', 'patient_id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(ScheduleDay::class);
    }

    public function payrolls(): MorphMany
    {
        return $this->morphMany(EmployeePayroll::class, 'owner');
    }

    public function prepareDoctor(): array
    {
        return [
            'id' => $this->id,
            'doctor_name' => $this->doctorUser->full_name ?? 'N/A',
            'doctor_department' => $this->department->title,
            'doctor_image' => $this->doctorUser->getApiImageUrlAttribute(),
        ];
    }

    public function prepareDoctorDetail(): array
    {
        return [
            'id' => $this->id,
            'doctor_name' => $this->doctorUser->full_name ?? 'N/A',
            'email' => $this->doctorUser->email ?? 'N/A',
            'phone' => $this->doctorUser->phone ?? 'N/A',
            'designation' => $this->doctorUser->designation ?? 'N/A',
            'doctor_department' => $this->department->title ?? 'N/A',
            'qualification' => $this->doctorUser->qualification ?? 'N/A',
            'blood_group' => $this->doctorUser->blood_group ?? 'N/A',
            'date_of_birth' => $this->doctorUser->dob ?? 'N/A',
            'gender' => $this->doctorUser->getGenderStringAttribute() ?? 'N/A',
            'specialist' => $this->specialist ?? 'N/A',
            'address1' => $this->address->address1 ?? 'N/A',
            'address2' => $this->address->address2 ?? 'N/A',
            'city' => $this->address->city ?? 'N/A',
            'zip' => $this->address->zip ?? 'N/A',
        ];
    }
}
