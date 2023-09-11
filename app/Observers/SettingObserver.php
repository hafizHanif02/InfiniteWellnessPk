<?php

namespace App\Observers;

use App\Models\Setting;

class SettingObserver
{
    public function created(Setting $setting): void
    {
        Setting::flushQueryCache();
    }

    public function updated(Setting $setting): void
    {
        Setting::flushQueryCache();
    }
}
