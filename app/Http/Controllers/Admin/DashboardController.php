<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use App\Models\Package;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        // Mendapatkan jumlah total booking
        $bookings_count = Booking::count();

        // Mendapatkan total pembayaran yang telah dibayarkan hari ini
        $payments_paid_today_sum = Payment::where('status', 'paid')
            ->whereDate('created_at', Carbon::today())
            ->sum('amount');

        // Mendapatkan jumlah total pengguna (users)
        $users_count = User::count();

        // Mendapatkan jumlah total paket (packages)
        $packages_count = Package::count();

        return view('admin.dashboard.index', compact(
            'bookings_count',
            'payments_paid_today_sum',
            'users_count',
            'packages_count'
        ));
    }
}
