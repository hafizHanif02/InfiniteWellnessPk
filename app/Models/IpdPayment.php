<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class IpdPayment extends Model implements HasMedia
{
    use InteractsWithMedia;

    public const IPD_PAYMENT_PATH = 'ipd_payments';

    public const PAYMENT_MODES_STRIPE = 3;

    const PAYMENT_MODES = [
        1 => 'Cash',
        2 => 'Cheque',
        3 => 'Stripe',
    ];

    public $fillable = [
        'ipd_patient_department_id',
        'payment_mode',
        'date',
        'notes',
        'amount',
        'transaction_id',
        'currency_symbol',
    ];

    protected $casts = [
        'id' => 'integer',
        'ipd_patient_department_id' => 'integer',
        'payment_mode' => 'integer',
        'date' => 'date',
        'amount' => 'integer',
        'transaction_id' => 'integer',
        'notes' => 'string',
        'currency_symbol' => 'string',
    ];

    public static $rules = [
        'payment_mode' => 'required',
        'date' => 'required|date',
        'amount' => 'required',
        'notes' => 'nullable|string',
    ];

    protected $appends = ['ipd_payment_document_url', 'payment_mode_name'];

    public function getIpdPaymentDocumentUrlAttribute()
    {
        $media = $this->media->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return '';
    }

    public function getPaymentModeNameAttribute()
    {
        return self::PAYMENT_MODES[$this->payment_mode];
    }
}
