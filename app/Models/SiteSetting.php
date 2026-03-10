<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    protected static function booted(): void
    {
        $flush = static function (SiteSetting $setting): void {
            Cache::forget('site_setting:'.$setting->key);
            Cache::forget('site_settings:landing');
        };

        static::saved($flush);
        static::deleted($flush);
    }
}
