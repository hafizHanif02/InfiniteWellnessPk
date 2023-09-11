<?php

namespace App\Observers\Transfer;

use App\Models\Log;
use App\Models\Shift\Transfer;

class TransferObserver
{
    public function created(Transfer $transfer): void
    {
        Log::create([
            'action' => 'Added new transfer '.$transfer->name,
            'action_by_user_id' => auth()->id(),
        ]);
    }

    public function updated(Transfer $transfer): void
    {
        Log::create([
            'action' => 'Updated transfer '.$transfer->name,
            'action_by_user_id' => auth()->id(),
        ]);
    }

    public function deleted(Transfer $transfer): void
    {
        Log::create([
            'action' => 'Deleted transfer '.$transfer->name,
            'action_by_user_id' => auth()->id(),
        ]);
    }
}
