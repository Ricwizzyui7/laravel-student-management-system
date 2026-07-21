<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $fillable = ['key', 'value'];

    public $timestamps = true;

    /**
     * Get or set a setting value. If a default is provided and key doesn't exist,
     * create it with the default.
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        $setting = static::where('key', $key)->first();

        if ($setting) {
            return $setting->value;
        }

        if ($default !== null) {
            static::create(['key' => $key, 'value' => $default]);
            return $default;
        }

        return null;
    }

    /**
     * Set a setting value, creating or updating as needed.
     */
    public static function put(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
