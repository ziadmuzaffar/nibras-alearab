<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class Portfolio extends Model
{
    use HasFactory, HasTranslations;

    /**
     * Translatable attributes.
     *
     * @var array<int, string>
     */
    public array $translatable = [
        'title',
        'client_name',
        'description',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'client_name',
        'image',
        'category_id',
        'description',
    ];

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
     * Get the category that owns the portfolio item.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the accessible image URL.
     */
    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            return '';
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        return asset($this->image);
    }
}
