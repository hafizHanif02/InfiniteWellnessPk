<?php

namespace App\Observers\Purchase;

use App\Models\Log;
use App\Models\Purchase\Requistion;

class RequistionObserver
{
    public function created(Requistion $requistion): void
    {
        Log::create([
            'action' => 'Added new requistion '.$requistion->name,
            'action_by_user_id' => auth()->id(),
        ]);
    }

    public function updated(Requistion $requistion): void
    {
        Log::create([
            'action' => 'Updated requistion '.$requistion->name,
            'action_by_user_id' => auth()->id(),
        ]);
    }

    public function deleted(Requistion $requistion): void
    {
        Log::create([
            'action' => 'Deleted requistion '.$requistion->name,
            'action_by_user_id' => auth()->id(),
        ]);
    }
}
