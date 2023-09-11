<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enquiry extends Model
{
    public $fillable = [
        'full_name',
        'email',
        'contact_no',
        'type',
        'message',
        'viewed_by',
        'status',
    ];

    const ALL = 2;

    const READ = 1;

    const UNREAD = 0;

    const STATUS_ARR = [
        self::ALL => 'All',
        self::READ => 'Read',
        self::UNREAD => 'Unread',
    ];

    const TYPE_GENERAL = 'General Inquiry';

    const TYPE_FEEDBACK = 'Feedback/Suggestions';

    const TYPE_RESIDENTIAL = 'Residential Care';

    public $appends = ['enquiry_type'];

    protected $casts = [
        'id' => 'integer',
        'full_name' => 'string',
        'email' => 'string',
        'contact_no' => 'string',
        'type' => 'integer',
        'message' => 'string',
        'viewed_by' => 'integer',
        'status' => 'boolean',
    ];

    public static $rules = [
        'full_name' => 'required',
        'email' => 'required|email:filter',
        'contact_no' => 'required|numeric',
        'type' => 'required',
        'message' => 'required|max:5000',
    ];

    public static $reCaptchaAttributes = [
        'g-recaptcha-response' => 'Google reCaptcha',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'viewed_by');
    }

    public function getEnquiryTypeAttribute()
    {
        if ($this->type == 1) {
            return self::TYPE_GENERAL;
        } elseif ($this->type == 2) {
            return self::TYPE_FEEDBACK;
        } elseif ($this->type == 3) {
            return self::TYPE_RESIDENTIAL;
        }
    }
}
