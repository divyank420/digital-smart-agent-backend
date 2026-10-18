<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigSetting extends Model
{
    use HasFactory;

    protected $table = 'config_settings';

    protected $fillable = [
        'config_key',
        'category',
        'label',
        'type',
        'default_value',
        'options',
        'message',
        'is_required',
        'is_removable',
        'is_active',
        'access_level',
        'sort_order',
    ];

    protected $casts = [
        'default_value' => 'json',
        'options' => 'json',
        'is_required' => 'boolean',
        'is_removable' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Scope to fetch only active settings
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope to filter by category (e.g., company, general)
    public function scopeOfCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    // Scope to filter by access level (e.g., all, owner)
    public function scopeForAccessLevel($query, string $level)
    {
        return $query->where('access_level', $level);
    }
}
