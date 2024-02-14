<?php

namespace App\Services;

use App\Models\Setting;

class SettingsService
{
    public function loadSettings()
    {
        // Memuat pengaturan dari database
        return Setting::latest()->first();
    }
}
