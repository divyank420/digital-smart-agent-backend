<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'config_key' => 'collection_updates',
                'category' => 'company',
                'label' => 'Collection Updates',
                'type' => 'select',
                'default_value' => json_encode("manual"),
                'options' => json_encode(["Manual Whatsapp Updates","None"]),
                'message' => 'Which method you want to updated your customer about entry.',
                'is_required' => true,
                'is_removable' => false,
                'is_active' => true,
                'access_level' => 'owner',
                'sort_order' => 100,
            ],
            [
                'config_key' => 'entry_level_denomination',
                'category' => 'company',
                'label' => 'Denomination at Collection Level',
                'type' => 'boolean',
                'default_value' => json_encode(true),
                'options' => null,
                'message' => 'Enable or disable cash denomination breakdown when you do collection.',
                'is_required' => true,
                'is_removable' => false,
                'is_active' => true,
                'access_level' => 'owner',
                'sort_order' => 110,
            ],
        ];

        DB::table('config_settings')->insert($settings);
    }
}