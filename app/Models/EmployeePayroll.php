<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class EmployeePayroll extends Model
{
    const STATUS_ALL = 2;

    const PAID = 1;

    const NOT_PAID = 0;

    const STATUS = [0 => 'Unpaid', 1 => 'Paid'];

    const MONTHS = [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ];

    const TYPES = [
        6 => 'Accountant',
        7 => 'Case Manager',
        2 => 'Doctor',
        3 => 'Lab Technician',
        1 => 'Nurse',
        5 => 'Pharmacist',
        4 => 'Receptionist',
    ];

    const CLASS_TYPES = [
        1 => Nurse::class,
        2 => Doctor::class,
        3 => LabTechnician::class,
        4 => Receptionist::class,
        5 => Pharmacist::class,
        6 => Accountant::class,
        7 => CaseHandler::class,
    ];

    const STATUS_ARR = [
        self::STATUS_ALL => 'All',
        self::PAID => 'Paid',
        self::NOT_PAID => 'Unpaid',
    ];

    const FILTER_STATUS_ARR = [
        0 => 'All',
        1 => 'Paid',
        2 => 'Unpaid',
    ];

    const PYAYROLLUSERS = [
        Doctor::class, Nurse::class, LabTechnician::class, Receptionist::class, Pharmacist::class, Accountant::class,
        CaseHandler::class,
    ];

    protected $appends = ['type_string'];

    public $fillable = [
        'sr_no',
        'payroll_id',
        'type',
        'owner_id',
        'owner_type',
        'month',
        'year',
        'net_salary',
        'status',
        'basic_salary',
        'allowance',
        'deductions',
        'currency_symbol',
    ];

    protected $casts = [
        'id' => 'integer',
        'sr_no' => 'integer',
        'payroll_id' => 'string',
        'type' => 'integer',
        'owner_id' => 'integer',
        'owner_type' => 'string',
        'month' => 'string',
        'year' => 'integer',
        'net_salary' => 'double',
        'status' => 'int',
        'basic_salary' => 'double',
        'allowance' => 'double',
        'deductions' => 'double',
        'currency_symbol' => 'string',
    ];

    public static $rules = [
        'sr_no' => 'required|numeric',
        'payroll_id' => 'required',
        'type' => 'required|numeric',
        'owner_id' => 'required',
        'month' => 'required',
        'year' => 'required',
        'net_salary' => 'required',
        'basic_salary' => 'required',
    ];

    public function owner(): MorphTo
    {
        return $this->morphTo();
    }

    public function getTypeStringAttribute()
    {
        return self::TYPES[$this->type];
    }

    public function preparePayroll(): array
    {
        return [
            'id' => $this->id,
            'payroll_id' => $this->payroll_id ?? 'N/A',
            'month' => $this->month ?? 'N/A',
            'year' => $this->year ?? 'N/A',
            'status' => $this->status == 1 ? 'Paid' : 'Unpaid',
        ];
    }

    public function prepareDoctorPayrollDetail(): array
    {
        return [
            'id' => $this->id,
            'sr_no' => $this->sr_no ?? 'N/A',
            'payroll_id' => $this->payroll_id ?? 'N/A',
            'month' => $this->month ?? 'N/A',
            'year' => $this->year ?? 'N/A',
            'net_salary' => $this->net_salary ?? 'N/A',
            'status' => self::STATUS[$this->status],
            'basic_salary' => $this->basic_salary ?? 'N/A',
            'allowance' => $this->allowance ?? 'N/A',
            'deductions' => $this->deductions ?? 'N/A',
            'created_on' => $this->created_at->diffForHumans() ?? 'N/A',
            'currency_symbol' => getCurrencySymbol(),
        ];
    }
}
