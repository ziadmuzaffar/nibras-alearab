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

if (!function_exists('whatsapp_link')) {
    /**
     * Generate a clean WhatsApp click-to-chat URL using system settings.
     *
     * @param string|null $customMessage
     * @return string
     */
    function whatsapp_link(?string $customMessage = null): string
    {
        $rawPhone = (string) setting('whatsapp', setting('mobile', '966501234567'));
        $phone = preg_replace('/[^0-9]/', '', $rawPhone);

        if (str_starts_with($phone, '00')) {
            $phone = substr($phone, 2);
        } elseif (str_starts_with($phone, '05')) {
            $phone = '966' . substr($phone, 1);
        } elseif (str_starts_with($phone, '5') && strlen($phone) === 9) {
            $phone = '966' . $phone;
        }

        if (empty($phone)) {
            $phone = '966501234567';
        }

        $message = $customMessage ?? (string) setting('whatsapp_default_message', 'مرحباً، أود الاستفسار عن خدمات الطباعة والتغليف لدى مطبعة نبراس العرب.');

        return 'https://wa.me/' . $phone . ($message !== '' ? '?text=' . urlencode($message) : '');
    }
}
