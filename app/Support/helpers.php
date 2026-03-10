<?php

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

if (! function_exists('site_setting')) {
    function site_setting(string $key, ?string $default = null): ?string
    {
        return Cache::remember('site_setting:'.$key, 600, function () use ($key, $default) {
            $value = SiteSetting::query()->where('key', $key)->value('value');

            return $value ?? $default;
        });
    }
}

if (! function_exists('site_settings_for_landing')) {
    function site_settings_for_landing(): array
    {
        return Cache::remember('site_settings:landing', 600, function () {
            return [
                'site_name' => site_setting('site_name', 'Jessica Nails Studio'),
                'whatsapp_number' => site_setting('whatsapp_number', '920236307'),
                'address' => site_setting('address', 'Lima, Perú'),
            ];
        });
    }
}
