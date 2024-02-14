<?php

namespace App\Listeners;

use App\Events\PaymentExpired;
use App\Models\Payment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandlePaymentExpired
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PaymentExpired $event): void
    {
          // Handle logic for expired payment, for example:
        $payment = Payment::find($event->paymentId);
        $payment->status = 'expired';
        $payment->save();
    }
}
