<?php

namespace App\Observers\Inventory;

use App\Models\Inventory\Product;
use App\Models\Log;

class ProductObserver
{
    public function created(Product $product): void
    {
        Log::create([
            'action' => 'Added new product '.$product->product_name,
            'action_by_user_id' => auth()->id(),
        ]);
    }

    public function updated(Product $product): void
    {
        Log::create([
            'action' => 'Updated product '.$product->product_name,
            'action_by_user_id' => auth()->id(),
        ]);
    }

    public function deleted(Product $product): void
    {
        Log::create([
            'action' => 'Deleted product '.$product->product_name,
            'action_by_user_id' => auth()->id(),
        ]);
    }
}
