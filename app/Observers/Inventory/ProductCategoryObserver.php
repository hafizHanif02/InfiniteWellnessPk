<?php

namespace App\Observers\Inventory;

use App\Models\Inventory\ProductCategory;
use App\Models\Log;

class ProductCategoryObserver
{
    public function created(ProductCategory $productCategory): void
    {
        Log::create([
            'action' => 'Added new category '.$productCategory->name,
            'action_by_user_id' => auth()->id(),
        ]);
    }

    public function updated(ProductCategory $productCategory): void
    {
        Log::create([
            'action' => 'Updated category '.$productCategory->name,
            'action_by_user_id' => auth()->id(),
        ]);
    }

    public function deleted(ProductCategory $productCategory): void
    {
        Log::create([
            'action' => 'Deleted category '.$productCategory->name,
            'action_by_user_id' => auth()->id(),
        ]);
    }
}
