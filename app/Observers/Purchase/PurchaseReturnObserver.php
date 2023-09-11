<?php

namespace App\Observers\Purchase;

use App\Models\Log;
use App\Models\Purchase\PurchaseReturnNote;

class PurchaseReturnObserver
{
    public function created(PurchaseReturnNote $purchaseReturnNote): void
    {
        Log::create([
            'action' => 'Added new purchase return note '.$purchaseReturnNote->name,
            'action_by_user_id' => auth()->id(),
        ]);
    }

    public function updated(PurchaseReturnNote $purchaseReturnNote): void
    {
        Log::create([
            'action' => 'Updated purchase return note '.$purchaseReturnNote->name,
            'action_by_user_id' => auth()->id(),
        ]);
    }

    public function deleted(PurchaseReturnNote $purchaseReturnNote): void
    {
        Log::create([
            'action' => 'Deleted purchase return note '.$purchaseReturnNote->name,
            'action_by_user_id' => auth()->id(),
        ]);
    }
}
