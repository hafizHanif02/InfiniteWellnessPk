<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ItemStock extends Model implements HasMedia
{
    use InteractsWithMedia;

    public const PATH = 'item_stocks';

    public static $rules = [
        'itemcategory_id' => 'required',
        'item_id' => 'required',
        'supplier_name' => 'string|nullable',
        'store_name' => 'string|nullable',
        'quantity' => 'numeric|required',
        'purchase_price' => 'numeric|required',
        'description' => 'nullable',
        'attachment' => 'nullable|mimes:jpeg,png,pdf,docx,doc',
    ];

    public $fillable = [
        'itemcategory_id',
        'item_id',
        'supplier_name',
        'store_name',
        'quantity',
        'purchase_price',
        'description',
        'currency_symbol',
    ];

    protected $casts = [
        'id' => 'integer',
        'itemcategory_id' => 'integer',
        'item_id' => 'integer',
        'supplier_name' => 'string',
        'store_name' => 'string',
        'quantity' => 'integer',
        'purchase_price' => 'real',
        'description' => 'string',
        'currency_symbol' => 'string',
    ];

    protected $appends = ['item_stock_url'];

    public function getItemStockUrlAttribute()
    {
        /** @var Media $media */
        $media = $this->media->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return '';
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
