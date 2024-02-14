<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($payment) {
            // Panggil fungsi untuk memeriksa status booking setelah pembayaran baru dibuat
            $payment->checkAndUpdateBookingStatus();
        });
    }

    public function checkAndUpdateBookingStatus()
    {
        $booking = $this->booking;

        if ($booking->isFullyPaid()) {
            $booking->update(['status' => 'booked']);
        }
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
