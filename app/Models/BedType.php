<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BedType extends Model
{
    public $fillable = [
        'title',
        'description',
    ];

    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'description' => 'string',
    ];

    public static $rules = [
        'title' => 'required|unique:bed_types,title',
    ];

    public function patientNameRetrieved($beds): array
    {
        $data = [];
        foreach ($beds as $bed) {
            $data[] = [
                'id' => $bed->id,
                'name' => ! $bed->is_available ? ! $bed->bedAssigns->isEmpty() && $bed->bedAssigns[0]->discharge_date == null ? $bed->bedAssigns[0]->patient->patientUser->full_name : $this->preparePatientAdmissionData($bed->patientAdmission, $bed->id) : $bed->name,
                'status' => (bool) $bed->is_available,
            ];
        }

        return $data;
    }

    public function preparePatientAdmissionData($patientAdmissions, $id)
    {
        foreach ($patientAdmissions as $patientAdmission) {
            if ($patientAdmission->bed->id == $id && ! $patientAdmission->bed->is_available && ($patientAdmission->discharge_date == null)) {
                return $patientAdmission->patient->patientUser->full_name;
            }
        }
    }

    public function prepareData(): array
    {
        return [
            'bed_title' => $this->title,
            'bed' => $this->patientNameRetrieved($this->beds) ?? [],
        ];
    }

    public function bedNameRetrieved($beds): array
    {
        $data = [];
        foreach ($beds as $bed) {
            $data[] = [
                'id' => $bed->id,
                'name' => $bed->name,
                'status' => (bool) $bed->is_available,
            ];
        }

        return $data;
    }

    public function prepareBedData(): array
    {
        return [
            'bed_title' => $this->title,
            'bed' => $this->bedNameRetrieved($this->beds) ?? [],
        ];
    }

    public function beds(): HasMany
    {
        return $this->hasMany(Bed::class, 'bed_type');
    }
}
