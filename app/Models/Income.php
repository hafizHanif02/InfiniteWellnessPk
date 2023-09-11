<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Income extends Model implements HasMedia
{
    use InteractsWithMedia;

    const PATH = 'income';

    const INCOME_HEAD = [
        1 => 'Canteen Rent',
        2 => 'Hospital Charges',
        3 => 'Special Campaign',
        4 => 'Vehicle Stand Charges',
    ];

    const FILTER_INCOME_HEAD = [
        0 => 'All',
        2 => 'Hospital Charges',
        3 => 'Special Campaign',
        1 => 'Canteen Rent',
        4 => 'Vehicle Stand Charges',
    ];

    public $fillable = [
        'income_head',
        'name',
        'date',
        'currency_symbol',
        'invoice_number',
        'amount',
        'description',
    ];

    protected $casts = [
        'id' => 'integer',
        'income_head' => 'integer',
        'name' => 'string',
        'date' => 'date',
        'invoice_number' => 'string',
        'amount' => 'double',
        'description' => 'string',
        'currency_symbol' => 'string',
    ];

    public static $rules = [
        'income_head' => 'required|string',
        'name' => 'required|unique:incomes,name|string',
        'date' => 'required|date',
        'invoice_number' => 'string|nullable',
        'amount' => 'required',
        'description' => 'string|nullable',
    ];

    protected $appends = ['document_url'];

    public function getDocumentUrlAttribute()
    {
        $media = $this->media->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return '';
    }

    public function UserRole(): array
    {
        return Department::orderBy('name')->pluck('name', 'id')->toArray();
    }
}
