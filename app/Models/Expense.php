<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Expense extends Model implements HasMedia
{
    use InteractsWithMedia;

    const PATH = 'expenses';

    const EXPENSE_HEAD = [
        1 => 'Building Rent',
        3 => 'Equipments',
        2 => 'Electricity Bill',
        4 => 'Power Generator Fuel Charge',
        6 => 'Telephone Bill',
        5 => 'Tea Expense',
    ];

    const FILTER_EXPENSE_HEAD = [
        0 => 'All',
        1 => 'Building Rent',
        3 => 'Equipments',
        2 => 'Electricity Bill',
        6 => 'Telephone Bill',
        4 => 'Power Generator Fuel Charge',
        5 => 'Tea Expense',
    ];

    public $fillable = [
        'expense_head',
        'name',
        'date',
        'invoice_number',
        'amount',
        'description',
        'currency_symbol',
    ];

    protected $casts = [
        'id' => 'integer',
        'expense_head' => 'integer',
        'name' => 'string',
        'date' => 'date',
        'invoice_number' => 'string',
        'amount' => 'double',
        'description' => 'string',
        'currency_symbol' => 'string',
    ];

    public static $rules = [
        'expense_head' => 'required|string',
        'name' => 'required|unique:expenses,name|string',
        'date' => 'required|date',
        'amount' => 'string|required',
        'description' => 'string|nullable',
        'invoice_number' => 'string|nullable',
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
}
