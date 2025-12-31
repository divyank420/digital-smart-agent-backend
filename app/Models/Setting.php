<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'saving_settings';

    protected $fillable = [
        'key',
        'value',
    ];

    public static function getValue($key, $default = null)
    {
        return cache()->remember(
            "setting_{$key}",
            3600,
            fn () => static::where('setting_key', $key)->value('setting_value') ?? $default
        );
    }
}
