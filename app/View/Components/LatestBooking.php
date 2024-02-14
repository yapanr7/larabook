<?php
// app/View/Components/LatestBooking.php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Booking;

class LatestBooking extends Component
{
    public $latestBooking;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // Retrieve the latest booking for the authenticated user
        $user = auth()->user();
        $this->latestBooking = Booking::where('user_id', $user->id)
            ->latest('created_at')->take(5)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.latest-booking');
    }
}
