<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasFactory, HasTranslations;

    /**
     * Translatable attributes.
     *
     * @var array<int, string>
     */
    public array $translatable = [
        'name',
        'short_description',
        'description',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'short_description',
        'description',
        'specifications',
        'featured_image',
        'is_featured',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Safely decode JSON or fallback to a bilingual array if plain string is stored.
     */
    public function fromJson($value, $asObject = false): mixed
    {
        $decoded = parent::fromJson($value, $asObject);

        if ($decoded === null && is_string($value) && $value !== '') {
            return ['ar' => $value, 'en' => $value];
        }

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Set the specifications attribute as JSON.
     */
    public function setSpecificationsAttribute(mixed $value): void
    {
        if (is_null($value)) {
            $this->attributes['specifications'] = null;
            return;
        }

        $this->attributes['specifications'] = is_string($value)
            ? $value
            : json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Get the localized specifications array for the active locale.
     */
    public function getSpecificationsAttribute(mixed $value): array
    {
        $specs = is_string($value) ? json_decode($value, true) : $value;
        if (! is_array($specs) || empty($specs)) {
            return [];
        }

        if (array_key_exists('ar', $specs) || array_key_exists('en', $specs)) {
            $locale = app()->getLocale();
            if (! empty($specs[$locale]) && is_array($specs[$locale])) {
                return $specs[$locale];
            }

            $fallback = $specs['ar'] ?? $specs['en'] ?? [];

            return is_array($fallback) ? $fallback : [];
        }

        return $specs;
    }

    /**
     * Get specifications for a specific locale (used in admin edit forms).
     */
    public function getSpecificationsForLocale(string $locale): array
    {
        $raw = $this->attributes['specifications'] ?? null;
        $specs = is_string($raw) ? json_decode($raw, true) : $raw;
        if (! is_array($specs) || empty($specs)) {
            return [];
        }

        if (array_key_exists('ar', $specs) || array_key_exists('en', $specs)) {
            return isset($specs[$locale]) && is_array($specs[$locale]) ? $specs[$locale] : [];
        }

        return $locale === 'ar' ? $specs : [];
    }

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the images for the product.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order', 'asc');
    }

    /**
     * Get the quote requests for the product.
     */
    public function quoteRequests(): HasMany
    {
        return $this->hasMany(QuoteRequest::class);
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured products.
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get the accessible featured image URL.
     */
    public function getFeaturedImageUrlAttribute(): string
    {
        if (empty($this->featured_image)) {
            return '';
        }

        if (str_starts_with($this->featured_image, 'http://') || str_starts_with($this->featured_image, 'https://')) {
            return $this->featured_image;
        }

        return asset($this->featured_image);
    }
}
