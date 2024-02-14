<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Pastikan bahwa aplikasi sedang dijalankan dari HTTP request, bukan dari command line
        if (!$this->app->runningInConsole()) {
            // Cek apakah tabel 'settings' ada dalam basis data
            if (Schema::hasTable('settings')) {
                // Jika tabel 'settings' ada, maka dapat mengakses data setting
                $setting = Setting::first();
                view()->share('setting', $setting);
            }
        }
    }
}
