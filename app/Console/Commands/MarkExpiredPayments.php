<?php

namespace App\Console\Commands;

use App\Events\PaymentExpired;
use App\Models\Payment;
use Illuminate\Console\Command;

class MarkExpiredPayments extends Command
{
    protected $signature = 'app:mark-expired-payments';

    protected $description = 'Mark payments as expired';

    public function handle()
    {
        $expiredPayments = Payment::where('status', 'unpaid')
            ->where('created_at', '<=', now()->subDays(1))
            ->get();

        foreach ($expiredPayments as $payment) {
                $payment->status = 'expired';
                $payment->save();
            // event(new PaymentExpired($payment->id));
        }

        $this->info('Expired payments marked successfully.');
    }
}
