<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class FrontSetting extends Model implements HasMedia
{
    use InteractsWithMedia;

    public const PATH = 'front-settings';

    public const HOME_IMAGE_PATH = 'homepage-image';

    const ABOUT_US = 1;

    const HOME_PAGE = 2;

    const APPOINTMENT = 3;

    const STATUS_ARR = [
        self::ABOUT_US => 'About Us',
    ];

    public static $rules = [
        'about_us_title' => 'required',
        'about_us_mission' => 'required',
        'about_us_image' => 'nullable',
    ];

    public $fillable = [
        'key',
        'value',
        'type',
    ];

    protected $casts = [
        'id' => 'integer',
        'key' => 'string',
        'value' => 'string',
        'type' => 'string',
    ];

    public function getLogoUrlAttribute()
    {
        $media = $this->media->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return $this->value;
    }
}
