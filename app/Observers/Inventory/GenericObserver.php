<?php

namespace App\Observers\Inventory;

use App\Models\Inventory\Generic;
use App\Models\Log;

class GenericObserver
{
    public function created(Generic $generic): void
    {
        Log::create([
            'action' => 'Added new generic '.$generic->name,
            'action_by_user_id' => auth()->id(),
        ]);
    }

    public function updated(Generic $generic): void
    {
        Log::create([
            'action' => 'Updated generic '.$generic->name,
            'action_by_user_id' => auth()->id(),
        ]);
    }

    public function deleted(Generic $generic): void
    {
        Log::create([
            'action' => 'Deleted generic '.$generic->name,
            'action_by_user_id' => auth()->id(),
        ]);
    }
}
