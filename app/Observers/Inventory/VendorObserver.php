<?php

namespace App\Observers\Inventory;

use App\Models\Inventory\Vendor;
use App\Models\Log;

class VendorObserver
{
    public function created(Vendor $vendor): void
    {
        Log::create([
            'action' => 'Added new vendor '.$vendor->name,
            'action_by_user_id' => auth()->id(),
        ]);
    }

    public function updated(Vendor $vendor): void
    {
        Log::create([
            'action' => 'Updated vendor '.$vendor->name,
            'action_by_user_id' => auth()->id(),
        ]);
    }

    public function deleted(Vendor $vendor): void
    {
        Log::create([
            'action' => 'Deleted vendor '.$vendor->name,
            'action_by_user_id' => auth()->id(),
        ]);
    }
}
