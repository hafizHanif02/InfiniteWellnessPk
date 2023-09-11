<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LiveMeeting extends Model
{
    protected $fillable = [
        'consultation_title',
        'consultation_date',
        'consultation_duration_minutes',
        'description',
        'meta',
        'created_by',
        'password',
        'host_video',
        'participant_video',
        'status',
        'meeting_id',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'id' => 'integer',
        'consultation_title' => 'string',
        'consultation_date' => 'date',
        'consultation_duration_minutes' => 'string',
        'description' => 'string',
        'created_by' => 'integer',
        'password' => 'string',
        'host_video' => 'integer',
        'participant_video' => 'integer',
        'status' => 'integer',
        'meeting_id' => 'integer',
        'meta' => 'array',
    ];

    const STATUS_AWAITED = 0;

    const STATUS_CANCELLED = 1;

    const STATUS_FINISHED = 2;

    const status = [
        self::STATUS_AWAITED => 'Awaited',
        self::STATUS_CANCELLED => 'Cancelled',
        self::STATUS_FINISHED => 'Finished',
    ];

    const FILTER_STATUS = [
        0 => 'All',
        1 => 'Awaited',
        2 => 'Cancelled',
        3 => 'Finished',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'consultation_title' => 'required',
        'consultation_date' => 'required',
        'consultation_duration_minutes' => 'required|min:0|max:720',
    ];

    /**
     * @var string[]
     */
    protected $appends = ['status_text'];

    /**
     * @return string
     */
    public function getStatusTextAttribute()
    {
        return self::status[$this->status];
    }

    /**
     * @return BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'live_meetings_candidates', 'live_meeting_id', 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
