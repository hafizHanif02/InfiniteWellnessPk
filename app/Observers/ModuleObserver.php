<?php

namespace App\Observers;

use App\Models\Module;

class ModuleObserver
{
    public function created(Module $module): void
    {
        Module::flushQueryCache();
    }

    public function updated(Module $module): void
    {
        Module::flushQueryCache();
    }
}
