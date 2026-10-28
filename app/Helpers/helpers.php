<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    /**
     * Get or set a system setting.
     *
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    function setting(?string $key = null, mixed $default = null): mixed
    {
        if (is_null($key)) {
            return Setting::getAll();
        }

        return Setting::get($key, $default);
    }
}

if (!function_exists('setting_image')) {
    /**
     * Get setting image URL or fallback.
     *
     * @param string $key
     * @param string|null $default
     * @return string|null
     */
    function setting_image(string $key, ?string $default = null): ?string
    {
        return Setting::getImageUrl($key, $default);
    }
}
