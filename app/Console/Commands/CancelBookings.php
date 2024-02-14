<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class CancelBookings extends Command
{
    protected $signature = 'app:cancel-bookings';

    protected $description = 'Cancel bookings with newer bookings';

    public function handle()
    {
        $bookingsToCancel = Booking::where('status', 'pending')
            ->whereExists(function ($query) {
                $query->select('id')
                    ->from('bookings as b2')
                    ->whereColumn('b2.package_id', 'bookings.package_id')
                    ->where('b2.status', 'booked')
                    ->where('b2.created_at', '>', now()->subDays(1))
                    ->limit(1);
            })
            ->get();

        foreach ($bookingsToCancel as $booking) {
            $booking->status = 'canceled';
            $booking->save();
        }

        $this->info('Bookings canceled successfully.');
    }
}
