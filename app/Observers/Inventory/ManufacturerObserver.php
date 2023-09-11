<?php

namespace App\Observers\Inventory;

use App\Models\Inventory\Manufacturer;
use App\Models\Log;

class ManufacturerObserver
{
    public function created(Manufacturer $manufacturer): void
    {
        Log::create([
            'action' => 'Added new manufacturer '.$manufacturer->name,
            'action_by_user_id' => auth()->id(),
        ]);
    }

    public function updated(Manufacturer $manufacturer): void
    {
        Log::create([
            'action' => 'Updated manufacturer '.$manufacturer->name,
            'action_by_user_id' => auth()->id(),
        ]);
    }

    public function deleted(Manufacturer $manufacturer): void
    {
        Log::create([
            'action' => 'Deleted manufacturer '.$manufacturer->name,
            'action_by_user_id' => auth()->id(),
        ]);
    }
}
