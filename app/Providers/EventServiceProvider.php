<?php

namespace App\Providers;

use App\Models\Inventory\Dosage;
use App\Models\Inventory\Generic;
use App\Models\Inventory\Group;
use App\Models\Inventory\Manufacturer;
use App\Models\Inventory\Product;
use App\Models\Inventory\ProductCategory;
use App\Models\Inventory\Vendor;
use App\Models\Purchase\GoodReceiveNote;
use App\Models\Purchase\PurchaseReturnNote;
use App\Models\Purchase\Requistion;
use App\Models\Shift\Transfer;
use App\Observers\Inventory\GenericObserver;
use App\Observers\Inventory\GroupObserver;
use App\Observers\Inventory\ManufacturerObserver;
use App\Observers\Inventory\ProductCategoryObserver;
use App\Observers\Inventory\ProductObserver;
use App\Observers\Inventory\VendorObserver;
use App\Observers\Purchase\GoodReceiveNoteObserver;
use App\Observers\Purchase\PurchaseReturnObserver;
use App\Observers\Purchase\RequistionObserver;
use App\Observers\Transfer\TransferObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    protected $observers = [
        // Product::class => [ProductObserver::class],
        // Dosage::class => [DosageObserver::class],
        // ProductCategory::class => [ProductCategoryObserver::class],
        // Manufacturer::class => [ManufacturerObserver::class],
        // Generic::class => [GenericObserver::class],
        // Vendor::class => [VendorObserver::class],
        // Requistion::class => [RequistionObserver::class],
        // GoodReceiveNote::class => [GoodReceiveNoteObserver::class],
        // PurchaseReturnNote::class => [PurchaseReturnObserver::class],
        // Transfer::class => [TransferObserver::class],
    ];

    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
