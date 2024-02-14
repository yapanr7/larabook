<?php

namespace App\View\Components;

use App\Models\Setting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AuthLayout extends Component
{
    public $logo;
    public $app_name;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $setting = Setting::latest()->first();
        $this->logo = $setting->app_logo;
        $this->app_name = $setting->app_name ?? config('app.name');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.auth');
    }
}
