<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'description',
        'price',
        'file_path',
        'preview_image',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all orders for the product.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get preview image URL
     */
    public function getPreviewImageUrlAttribute()
    {
        if (!$this->preview_image) {
            return null;
        }

        // Use the stored path directly
        $path = $this->preview_image;
        // Extract just the filename for the route
        $filename = basename($path);
        return route('files.preview', $filename);
    }
}
