<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PortfolioPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'image_path',
        'caption',
        'tags',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    protected static function booted(): void
    {
        static::deleting(function (PortfolioPhoto $photo): void {
            if (! $photo->image_path) {
                return;
            }

            Storage::disk('public')->delete($photo->image_path);
        });
    }
}
