<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public static function isTimeSlotAvailable($date, $time)
    {
        $dateTime = Carbon::parse($date . ' ' . $time);
        $bookingTime = Carbon::parse($dateTime->format('H:i'));

        $isAvailable =  !self::where('date', $dateTime->format('Y-m-d'))
            ->where('time', $dateTime->format('H:i:s'))
            ->exists();
        return $isAvailable;
    }

    public function isFullyPaid()
    {
        $totalPaidAmount = $this->payments->where('status', 'paid')->sum('amount');
        return $totalPaidAmount >= $this->package->price;
    }
}
