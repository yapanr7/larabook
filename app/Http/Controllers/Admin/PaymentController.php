<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Payment::latest();

        // Filter by date range
        // Filter by date range
        if ($request->filled('date_range')) {
            $dateRange = explode(' to ', $request->input('date_range'));

            // Ensure both start and end dates are available
            if (count($dateRange) == 2) {
                $startDate = date('Y-m-d', strtotime($dateRange[0]));
                $endDate = date('Y-m-d', strtotime($dateRange[1]));
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }


        // Filter by payment status
        if ($request->filled('payment_status') && $request->input('payment_status') !== 'all') {
            $query->where('status', $request->input('payment_status'));
        }

        $payments = $query->paginate(10);
        $bookings = Booking::latest()->get();

        return view('admin.payments.index', compact('payments', 'bookings'));
    }

    public function edit(Payment $payment): View
    {
        return view('admin.payments.edit', compact('payment'));
    }

    public function store(Request $request)
    {
        try {
            $booking = Booking::findOrFail($request->booking_id);
            $request->validate([
                'booking_id' => 'required|exists:bookings,id',
                'amount' => [
                    'required',
                    'numeric',
                    'min:0',
                ],
                'method' => 'nullable|in:cash,bank,qris',
                'status' => 'nullable|in:unpaid,paid,failed,expired',
            ]);

            // Create a new payment dengan menggunakan user_id dari booking
            Payment::create([
                'booking_id' => $booking->id,
                'user_id' => $booking->user_id,
                'amount' => $request->amount,
                'method' => $request->method,
                'status' => $request->status ?? 'unpaid',
            ]);

            // dd($request);

            return redirect()->route('admin.payments.index')->with('success', 'Payment created successfully.');
        } catch (\Exception $e) {
            // Handle the exception (e.g., log or show an error message)
            return redirect()->route('admin.payments.index')->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $payment = Payment::findOrFail($id);
            $booking = $payment->booking;

            $request->validate([
                'amount' => [
                    'required',
                    'numeric',
                    'min:0',
                ],
                'method' => 'nullable|in:cash,bank,qris',
                'status' => 'nullable|in:unpaid,paid,failed,expired',
            ]);

            // Update pembayaran
            $payment->update([
                'user_id' => $booking->user_id,
                'amount' => $request->amount,
                'method' => $request->method,
                'status' => $request->status ?? 'unpaid',
            ]);

            return redirect()->route('admin.payments.index')->with('success', 'Payment updated successfully.');
        } catch (\Exception $e) {
            // Handle the exception (e.g., log or show an error message)
            return redirect()->route('admin.payments.index')->with('error', $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $payment = Payment::findOrFail($id);
            $payment->delete();

            return redirect()->route('admin.payments.index')->with('success', 'Payment deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.payments.index')->with('error', 'Failed to delete the payment.');
        }
    }

    public function changeStatus(Request $request, $id)
    {
        try {
            $payment = Payment::findOrFail($id);

            $request->validate([
                'status' => 'required|in:unpaid,paid,failed,expired',
            ]);

            // Update the payment status
            $payment->update([
                'status' => $request->status,
            ]);

            return redirect()->route('admin.payments.index')->with('success', 'Payment status changed successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.payments.index')->with('error', $e->getMessage());
        }
    }
}
