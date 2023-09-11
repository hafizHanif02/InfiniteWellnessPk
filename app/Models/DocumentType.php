<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentType extends Model
{
    public $fillable = [
        'name',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
    ];

    public static $rules = [
        'name' => 'required|string|unique:document_types,name',
    ];

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
