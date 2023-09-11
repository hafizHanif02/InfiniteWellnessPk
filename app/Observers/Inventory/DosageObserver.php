<?php

namespace App\Observers\Inventory;

use App\Models\Inventory\Dosage;
use App\Models\Log;

class DosageObserver
{
    public function created(Dosage $dosage): void
    {
        Log::create([
            'action' => 'Added new dosage '.$dosage->name,
            'action_by_user_id' => auth()->id(),
        ]);
    }

    public function updated(Dosage $dosage): void
    {
        Log::create([
            'action' => 'Updated dosage '.$dosage->name,
            'action_by_user_id' => auth()->id(),
        ]);
    }

    public function deleted(Dosage $dosage): void
    {
        Log::create([
            'action' => 'Deleted dosage '.$dosage->name,
            'action_by_user_id' => auth()->id(),
        ]);
    }
}
