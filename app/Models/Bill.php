<?php

namespace App\Models;

use App\Repositories\BillRepository;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;
use Str;

class Bill extends Model
{
    public $fillable = [
        'patient_admission_id',
        'patient_id',
        'bill_id',
        'bill_date',
        'amount',
        'currency_symbol',
        'payment_type',
        'discount_amount',
        'total_amount',
        'advance_amount',
    ];

    protected $casts = [
        'id' => 'integer',
        'patient_admission_id' => 'string',
        'currency_symbol' => 'string',
        'patient_id' => 'string',
        'bill_id' => 'string',
        'bill_date' => 'datetime',
        'amount' => 'double',
        'payment_type' => 'integer',
        'discount_amount' => 'float',
        'total_amount' => 'float',
        'advance_amount' => 'double',
    ];

    public static $rules = [
        'patient_id' => 'required|integer|min:1',
        'bill_date' => 'required|string',
    ];

    public static $messages = [
        'patient_id.required' => 'The Admission id field is required.',
        'min' => 'Please select at least one patient.',
    ];

    public function billItems(): HasMany
    {
        return $this->hasMany(BillItem::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function setBillDateAttribute($value)
    {
        $this->attributes['bill_date'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function patientAdmission(): HasOne
    {
        return $this->hasOne(PatientAdmission::class, 'patient_admission_id', 'patient_admission_id');
    }

    public static function generateUniqueBillId(): string
    {
        $billId = mb_strtoupper(Str::random(6));
        while (true) {
            $isExist = self::whereBillId($billId)->exists();
            if ($isExist) {
                self::generateUniqueBillId();
            }
            break;
        }

        return $billId;
    }

    public function prepareBillItems(): array
    {
        $data = [];
        foreach ($this->billItems as $bill_item) {
            $data[] = [
                'id' => $bill_item->id ?? 'N/A',
                'item_name' => $bill_item->item_name ?? 'N/A',
                'quantity' => $bill_item->qty ?? 'N/A',
                'price' => $bill_item->price ?? 'N/A',
                'total' => $bill_item->amount ?? 'N/A',
                'payment_type' => $bill_item->payment_type ?? 'N/A',
                'discount_amount' => $bill_item->discount_amount ?? 'N/A',
                'total_amount' => $bill_item->total_amount ?? 'N/A',
            ];
        }

        return $data;
    }

    public function prepareBills(): array
    {
        return [
            'id' => $this->id ?? 'N/A',
            'bill_id' => $this->bill_id ?? 'N/A',
            'bill_time' => Carbon::parse($this->bill_date)->format('g:i A') ?? 'N/A',
            'bill_date' => Carbon::parse($this->bill_date)->format('jS M, Y') ?? 'N/A',
            'amount' => $this->amount ?? 'N/A',
            'currency' => getCurrencySymbol() ?? 'N/A',
        ];
    }

    public function prepareBillDetails(): array
    {
        $admissionDate = Carbon::parse($this->patientAdmission->admission_date);
        $dischargeDate = Carbon::parse($this->patientAdmission->discharge_date);

        return [
            'id' => $this->id,
            'bill_id' => $this->bill_id,
            'bill_time' => isset($this->bill_date) ? Carbon::parse($this->bill_date)->format('g:i A') : 'N/A',
            'bill_date' => isset($this->bill_date) ? Carbon::parse($this->bill_date)->format('jS M, Y') : 'N/A',
            'amount' => $this->amount ?? 'N/A',
            'currency' => getCurrencySymbol() ?? 'N/A',
            'patient_admission_id' => $this->patient_admission_id ?? 'N/A',
            'admission_detail' => [
                'phone' => getLoggedInUser()->phone ?? 'N/A',
                'doctor' => $this->patientAdmission->doctor->doctorUser->full_name,
                'admission_date' => isset($this->patientAdmission->admission_date) ? Carbon::parse($this->patientAdmission->admission_date)->format('jS M, Y') : 'N/A',
                'admission_time' => isset($this->patientAdmission->admission_date) ? Carbon::parse($this->patientAdmission->admission_date)->format('g:i A') : 'N/A',
                'discharge_date' => isset($this->patientAdmission->discharge_date) ? Carbon::parse($this->patientAdmission->discharge_date)->format('jS M, Y') : 'N/A',
                'discharge_time' => isset($this->patientAdmission->discharge_date) ? Carbon::parse($this->patientAdmission->discharge_date)->format('g:i A') : 'N/A',
                'created_at' => $this->patientAdmission->created_at ? $this->patientAdmission->created_at->diffForHumans() : 'N/A',
            ],
            'insurance_detail' => [
                'package_name' => $this->patientAdmission->package->name ?? 'N/A',
                'insurance_name' => $this->patientAdmission->insurance->name ?? 'N/A',
                'total_days' => $admissionDate->diffInDays($dischargeDate) + 1,
                'policy_no' => $this->patientAdmission->insurance->policy_no ?? 'N/A',
            ],
            'item_details' => $this->prepareBillItems(),
            'bill_download' => $this->convertToPdf($this->id),
        ];
    }

    public function convertToPdf($id): string
    {
        $bill = Bill::with('billItems')->find($id);
        $data = App()->make(billRepository::class)->getSyncListForCreate($id);
        $data['bill'] = $bill;
        if (Storage::exists('bills/Bill-'.$bill->bill_id.'.pdf')) {
            Storage::delete('bills/Bill-'.$bill->bill_id.'.pdf');
        }
        $pdf = PDF::loadView('bills.bill_pdf', $data);
        Storage::disk(config('app.media_disc'))->put('bills/Bill-'.$bill->bill_id.'.pdf', $pdf->output());
        $url = Storage::url('bills/Bill-'.$bill->bill_id.'.pdf');

        return $url ?? 'N/A';
    }
}
