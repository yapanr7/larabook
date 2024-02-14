<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Booking;
use App\Models\Package;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class BookingController extends Controller
{

    public function index()
    {
        // Ambil semua booking yang dimiliki oleh user yang sedang login
        $userBookings = Booking::where('user_id', Auth::id())->latest()->get();

        return view('bookings.index', compact('userBookings'));
    }

    public function show($code)
    {
        $booking = Booking::where('code', $code)->first();
        $totalPaidAmount = $booking->payments->where('status', 'paid')->sum('amount');

        return view('bookings.show', compact('booking'));
    }


    public function cancel($code)
    {
        // Temukan booking berdasarkan kode
        $booking = Booking::where('code', $code)->first();
        // Pastikan booking ditemukan
        if (!$booking) {
            return redirect()->route('bookings.index')->with('error', 'Booking not found.');
        }
        // Pastikan booking dalam status 'pending'
        if ($booking->status !== 'pending') {
            return redirect()->route('bookings.index')->with('error', 'Cannot cancel booking in current status.');
        }
        // Pastikan user yang sedang login adalah pemilik booking
        if ($booking->user_id !== Auth::id()) {
            return redirect()->route('bookings.index')->with('error', 'You are not authorized to cancel this booking.');
        }
        // Cek apakah ada pembayaran yang telah dibayar
        $paidPayments = $booking->payments->where('status', 'paid')->count();
        if ($paidPayments > 0) {
            return redirect()->route('bookings.index')->with('error', 'Cannot cancel booking with paid payments.');
        }
        // Jika semua syarat terpenuhi, ubah status booking menjadi 'canceled'
        $booking->status = 'canceled';
        $booking->save();
        return redirect()->route('bookings.index')->with('success', 'Booking has been canceled.');
    }
}
