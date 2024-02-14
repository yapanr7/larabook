<?php

namespace App\Http\Controllers;

use App\Mail\BookingMail;
use App\Models\Booking;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::latest()->paginate(8);

        return view('packages.index', compact('packages'));
    }

    public function show($slug)
    {
        $package = Package::where('slug', $slug)->first();

        $today = Carbon::today();
        // Get months for the next 3 months
        $months = [];
        for ($i = 0; $i < 3; $i++) {
            $months[] = $today->copy()->addMonths($i)->format('Y-m');
        }
        return view('packages.show', compact('package',  'months'));
    }

    public function getDates(Request $request)
    {
        $month = $request->input('month');
        $dates = $this->getDatesForMonth($month);

        return response()->json($dates);
    }

    private function getDatesForMonth($month)
    {
        $selectedMonth = Carbon::parse($month);

        // Get the number of days in the month
        $numDays = cal_days_in_month(CAL_GREGORIAN, $selectedMonth->month, $selectedMonth->year);

        // Generate date range for the given month
        $dateRange = [];
        $currentDay = $selectedMonth->firstOfMonth();

        $today = Carbon::today();
        $dayTranslations = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];


        for ($i = 1; $i <= $numDays; $i++) {
            $date = $currentDay->format('Y-m-d');
            $formattedDate = $currentDay->format('l, j F Y');

            $hari = $dayTranslations[$currentDay->format('l')];
            $tanggal = $currentDay->format('d');

            // Check if the date is in the future or today
            if ($currentDay->isFuture() || $currentDay->isSameDay($today)) {
                $dateRange[] = [
                    'date' => $date,
                    'formatted' => $formattedDate,
                    'hari' => $hari,
                    'tanggal' => $tanggal

                ];
            }

            $currentDay->addDay();
        }

        return $dateRange;
    }

    public function getAvailableSlots(Request $request)
    {
        $date = $request->input('date');
        $selectedDate = Carbon::parse($date);
        $availableSlots = $this->allTimeSlot($selectedDate);
        return response()->json($availableSlots);
    }

    private function allTimeSlot($selectedDate)
    {
        // Ambil waktu saat ini
        $currentTime = Carbon::now();
        // Inisialisasi waktu awal pada pukul 07:00 pagi dari selectedDate
        $currentDateTime = $selectedDate->copy()->setSeconds(0)->setTime(7, 0, 0);

        // Ambil semua jam dalam rentang waktu pada hari yang diminta
        $allTimeSlots = collect();
        setlocale(LC_TIME, 'id_ID');
        Carbon::setLocale('id');

        while ($currentDateTime->format('Y-m-d') == $selectedDate->format('Y-m-d')) {
            if ($currentDateTime <= $currentTime) {
                $isAvailable = false;
            } else {
                // Cek apakah waktu ini terbooking
                $isBooked = Booking::where('date', $currentDateTime->format('Y-m-d'))
                    ->where('time', $currentDateTime->format('H:i:s'))
                    ->where('status', 'booked')
                    ->exists();

                $isAvailable = !$isBooked;
            }

            $allTimeSlots->push([
                'date' => $currentDateTime->copy()->format('l j F Y'),
                'time' => $currentDateTime->copy()->format('H:i'),
                'isAvailable' => $isAvailable,
            ]);

            $currentDateTime->addMinutes(30);

            // Jika sudah melewati jam 22:00, hentikan perulangan
            if ($currentDateTime->format('H:i') == '22:00') {
                break;
            }
        }

        return $allTimeSlots;
    }

    public function booking(Request $request)
    {
        $package_id = decrypt($request->package_id);
        // Validasi data input
        $validator = Validator::make($request->all(), [
            'package_id' => 'required',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'note' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            // Mulai transaksi database
            DB::beginTransaction();
            $package = Package::find($package_id);
            if ($package) {
                $existingBooking = Booking::where('date', $request->date)
                    ->where('time', $request->time)
                    ->where('status', 'booked')
                    ->first();
                if ($existingBooking) {
                    return response()->json(['error' => 'Pesan untuk slot waktu ini sudah terisi..'], 422);
                }
                $user_id = Auth::id();
                $code = 'BK' . Str::random(10);
                $booking = new Booking();
                $booking->package_id = $package_id;
                $booking->code = $code;
                $booking->date = $request->date;
                $booking->time = $request->time;
                $booking->note = $request->note;
                $booking->user_id = $user_id;
                $booking->save();
            }
            // Commit transaksi
            DB::commit();

            $user_email = Auth::user()->email;
            if ($user_email) {
                Mail::to($user_email)->send(new BookingMail($booking));
                flash()->addSuccess('Booking telah dibuat, silahkan lakukan pembayaran dan check email.');
            }

            // Return a JSON response indicating success
            return response()->json([
                'success' => true,
                'code' => $code,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->addInfo('Terjadi kesalahan : ', $e->getMessage());
            return response()->json(['error' => 'Failed to create booking. ' . $e->getMessage()], 500);
        }
    }
}
