<?php

namespace App\Models;

use App\Repositories\InvoiceRepository;
use Barryvdh\DomPDF\Facade as PDF;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Str;

class Invoice extends Model
{
    public const PENDING = 1;

    public const PAID = 0;

    public const STATUS_ALL = 2;

    public const STATUS_ARR = [
        self::STATUS_ALL => 'All',
        self::PENDING => 'Pending',
        self::PAID => 'Paid',
    ];

    public const FILTER_STATUS_ARR = [
        2 => 'All',
        0 => 'Paid',
        1 => 'Pending',
    ];

    public static $rules = [
        'patient_id' => 'required',
        'invoice_date' => 'required|date',
        'discount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
    ];

    public static $messages = [
        'patient_id.required' => 'The patient field is required.',
        'invoice_date.required' => 'The invoice date field is required.',
    ];

    public $appends = ['status_label'];

    public $fillable = [
        'patient_id',
        'invoice_date',
        'invoice_id',
        'amount',
        'discount',
        'status',
        'currency_symbol',
    ];

    protected $casts = [
        'id' => 'integer',
        'patient_id' => 'integer',
        'invoice_id' => 'string',
        'invoice_date' => 'date',
        'amount' => 'double',
        'discount' => 'double',
        'status' => 'boolean',
        'currency_symbol' => 'string',
    ];

    public function getStatusLabelAttribute()
    {
        return self::STATUS_ARR[$this->status];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function prepareInvoiceItem(): array
    {
        $data = [];
        foreach ($this->invoiceItems as $invoice_item) {
            $data[] = [
                'id' => $invoice_item->id,
                'account_name' => $invoice_item->account->name,
                'description' => $invoice_item->description ?? 'N/A',
                'quantity' => $invoice_item->quantity,
                'price' => $invoice_item->price,
                'total' => $invoice_item->quantity * $invoice_item->price,
            ];
        }

        return $data;
    }

    public static function generateUniqueInvoiceId()
    {
        $invoiceId = mb_strtoupper(Str::random(6));
        while (true) {
            $isExist = self::whereInvoiceId($invoiceId)->exists();
            if ($isExist) {
                self::generateUniqueInvoiceId();
            }
            break;
        }

        return $invoiceId;
    }

    public function prepareInvoice(): array
    {
        return [
            'id' => $this->id,
            'invoice_id' => $this->invoice_id,
            'invoice_date' => \Carbon\Carbon::parse($this->invoice_date)->format('d M, Y'),
            'amount' => $this->amount - ($this->discount ? ($this->amount * $this->discount / 100) : 0),
            'status' => $this->status,
            'currency' => getCurrencySymbol(),
        ];
    }

    public function prepareInvoiceDetails(): array
    {
        return [
            'id' => $this->id,
            'invoice_id' => $this->invoice_id,
            'invoice_date' => \Carbon\Carbon::parse($this->invoice_date)->format('d M, Y'),
            'patient_name' => $this->patient->patientUser->full_name,
            'issued_by' => getAppName(),
            'hospital_address' => Setting::where('key', '=', 'hospital_address')->first()->value,
            'address' => $this->patient->address ? $this->patient->address->address1.','.$this->patient->address->address2 : 'N/A',
            'city' => $this->patient->address->city ?? 'N/A',
            'zip' => $this->patient->address->zip ?? 'N/A',
            'currencySymbol' => getCurrencySymbol(),
            'invoice_download' => $this->convertToPdf($this->id),
            'invoice_items' => $this->prepareInvoiceItem(),
            'sub_total' => $this->amount,
            'discount' => $this->discount ? ($this->amount * $this->discount / 100) : 0,
            'total_amount' => $this->amount - ($this->discount ? ($this->amount * $this->discount / 100) : 0),
        ];
    }

    public function convertToPdf($id): string
    {
        $invoice = Invoice::with(['invoiceItems', 'patient'])->find($id);
        $data = App()->make(invoiceRepository::class)->getSyncListForCreate($id);
        $data['invoice'] = $invoice;
        $data['currencySymbol'] = getCurrencySymbol();
        if (Storage::exists('invoices/Invoice-'.$invoice->invoice_id.'.pdf')) {
            Storage::delete('invoices/Invoice-'.$invoice->invoice_id.'.pdf');
        }
        $pdf = PDF::loadView('invoices.invoice_pdf', $data);
        Storage::disk(config('app.media_disc'))->put('invoices/Invoice-'.$invoice->invoice_id.'.pdf', $pdf->output());
        $url = Storage::disk(config('app.media_disc'))->url('invoices/Invoice-'.$invoice->invoice_id.'.pdf');

        return $url ?? 'N/A';
    }
}
