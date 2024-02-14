<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = Booking::with('package', 'user')->latest();

        // Filter berdasarkan reference
        if ($request->has('reference')) {
            $bookings->where('code', 'like', '%' . $request->input('reference') . '%');
        }

        // Filter berdasarkan date_range
        if ($request->date_range) {
            $dates = explode(' to ', $request->date_range);
            $bookings->whereBetween('date', [$dates[0], $dates[1]]);
        }

        // Filter berdasarkan payment_status
        if ($request->has('booking_status') && $request->input('status') !== 'all') {
            $bookings->where('status', $request->input('booking_status'));
        }
        $bookings = $bookings->paginate(10);
        $users = User::all();
        $packages = Package::all();
        return view('admin.bookings.index', compact('bookings', 'users', 'packages'));
    }

    public function show($id)
    {
        $booking = Booking::with('package', 'user')->find($id);
        if (!$booking) {
            return redirect()->route('admin.bookings.index')->with('error', 'Booking not found.');
        }
        return view('admin.bookings.show', compact('booking'));
    }

    public function create()
    {
        // return view('admin.bookings.create', compact('booking'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'package_id' => 'required|exists:packages,id',
                'date' => 'required|date',
                'time' => 'required|date_format:H:i',
                'note' => 'nullable|string',
            ]);

            // Generate a unique code for the booking

            $code = 'BK' . Str::random(10);

            // Use a transaction to ensure data consistency in case of an exception
            DB::beginTransaction();

            // Create a new booking
            $booking = Booking::create([
                'user_id' => $request->user_id,
                'package_id' => $request->package_id,
                'code' => $code,
                'date' => $request->date,
                'time' => $request->time,
                'note' => $request->note,
                'status' => $request->status,
            ]);

            // Commit the transaction if everything is successful
            DB::commit();

            return redirect()->route('admin.bookings.index')->with('success', 'Booking created successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Get the exception message
            $errorMessage = $e->getMessage();

            // Display the exception message in the error feedback
            return redirect()->route('admin.bookings.index')->with('error', "Failed to create the booking. Error: $errorMessage");
        }
    }

    public function edit($id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return redirect()->route('admin.bookings.index')->with('error', 'Booking not found.');
        }

        $packages = Package::all();
        return view('admin.bookings.edit', compact('booking', 'packages'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return redirect()->route('admin.bookings.index')->with('error', 'Booking not found.');
        }

        // Validasi input
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'note' => 'nullable|string|max:255',
            'status' => 'nullable',
        ]);

        try {
            $booking->date = $request->date;
            $booking->time = $request->time;
            $booking->note = $request->note;
            $booking->status = $request->status;
            $booking->save();

            return redirect()->route('admin.bookings.index')->with('success', $booking->code . ' Booking updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.bookings.edit', $id)->with('warning', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->delete();
            return redirect()->route('admin.bookings.index')->with('success', 'Booking has been deleted.');
        } catch (\Exception $e) {
            return redirect()->route('admin.bookings.index')->with('error', $e->getMessage());
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            $bookingId = $request->booking_id;
            $newStatus = $request->new_status; // Sesuaikan dengan nama input yang sesuai dengan form modal

        // dd($bookingId);
            $booking = Booking::findOrFail($bookingId);
            // dd($booking);
            $booking->status = $newStatus;
            $booking->save();

            return redirect()->route('admin.bookings.index')->with('success', 'Status booking berhasil diubah.');
        } catch (\Exception $e) {
            return redirect()->route('admin.bookings.index')->with('error', 'Gagal mengubah status booking.' . $e->getMessage());
        }
    }

    public function changeDownloadLink(Request $request)
    {

        try {
            $bookingId = $request->booking_id;
            $newDownloadLink = $request->new_download_link;

            $booking = Booking::findOrFail($bookingId);

            if (!$booking) {
                return redirect()->route('admin.bookings.index')->with('error', 'Booking not found.');
            }

            $booking->download = $newDownloadLink;
            $booking->save();

            return redirect()->route('admin.bookings.index')->with('success', 'Download link telah diubah.');
        } catch (\Exception $e) {
            return redirect()->route('admin.bookings.index')->with('error', 'Gagal mengubah download link: ' . $e->getMessage());
        }
    }

}
