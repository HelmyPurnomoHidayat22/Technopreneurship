<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'note',
        'custom_style',
        'icon',
    ];

    /**
     * Get all products for the category.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
