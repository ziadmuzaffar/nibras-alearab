<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    /**
     * Cache key for all settings.
     */
    public const CACHE_KEY = 'app_system_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Retrieve all settings as key-value pairs (cached).
     */
    public static function getAll(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            try {
                return static::pluck('value', 'key')->toArray();
            } catch (\Throwable $e) {
                return [];
            }
        });
    }

    /**
     * Retrieve a setting value by key.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $all = static::getAll();

        if (array_key_exists($key, $all)) {
            $value = $all[$key];
            return ($value === null || $value === '') ? $default : $value;
        }

        return $default;
    }

    /**
     * Check if a setting key exists and is not empty.
     */
    public static function has(string $key): bool
    {
        $value = static::get($key);
        return !empty($value);
    }

    /**
     * Get image URL for image settings (logo, favicon, etc.)
     */
    public static function getImageUrl(string $key, ?string $default = null): ?string
    {
        $path = static::get($key);
        if ($path && file_exists(public_path($path))) {
            return asset($path);
        }

        return $default ? asset($default) : null;
    }

    /**
     * Set or update a setting by key.
     */
    public static function set(string $key, mixed $value): static
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        static::clearCache();

        return $setting;
    }

    /**
     * Set multiple settings at once.
     */
    public static function setMany(array $settings): void
    {
        foreach ($settings as $key => $value) {
            static::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        static::clearCache();
    }

    /**
     * Clear the cached settings.
     */
    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}

