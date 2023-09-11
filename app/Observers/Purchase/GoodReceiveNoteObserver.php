<?php

namespace App\Observers\Purchase;

use App\Models\Log;
use App\Models\Purchase\GoodReceiveNote;

class GoodReceiveNoteObserver
{
    public function created(GoodReceiveNote $goodReceiveNote): void
    {
        Log::create([
            'action' => 'Added new good receive note '.$goodReceiveNote->grn_no,
            'action_by_user_id' => auth()->id(),
        ]);
    }

    public function updated(GoodReceiveNote $goodReceiveNote): void
    {
        Log::create([
            'action' => 'Updated good receive note '.$goodReceiveNote->grn_no,
            'action_by_user_id' => auth()->id(),
        ]);
    }

    public function deleted(GoodReceiveNote $goodReceiveNote): void
    {
        Log::create([
            'action' => 'Deleted good receive note '.$goodReceiveNote->grn_no,
            'action_by_user_id' => auth()->id(),
        ]);
    }
}
