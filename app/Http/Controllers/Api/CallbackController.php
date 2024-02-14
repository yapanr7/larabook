<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Http\Request;

class CallbackController extends Controller
{
    public function handle(Request $request)
    {
        try {

            $setting = Setting::latest()->first();

            $merchantCode = $setting->tripay_merchant_code ?? '';
            $apiKey = $setting->tripay_api_key ?? '';
            $privateKey =  $setting->tripay_private_key;
            $callbackSignature = $request->header('X-CALLBACK-SIGNATURE');
            $json = $request->getContent();
            $signature = hash_hmac('sha256', $json, $privateKey);

            if ($signature !== (string) $callbackSignature) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid signature',
                ], 401);
            }

            $event = (string) $request->header('X-CALLBACK-EVENT');

            if ($event !== 'payment_status') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unrecognized callback event, no action was taken',
                ], 400);
            }

            $data = json_decode($json);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid data sent by Tripay',
                ], 400);
            }

            if ($data->is_closed_payment === 1) {
                $bookingCode = $data->merchant_ref;
                $payment = Payment::whereHas('booking', function ($query) use ($bookingCode) {
                    $query->where('code', $bookingCode);
                })
                ->where('status', 'unpaid')
                ->first();

                if (!$payment) {
                    return response()->json([
                        'success' => false,
                        'payment' => $data,
                        'message' => 'No payment found or already paid',
                    ], 400);
                }

                $status = strtoupper((string) $data->status);

                switch ($status) {
                    case 'PAID':
                        $payment->update(['status' => $status]);

                        if ($payment->booking && $payment->booking->status === 'pending') {
                            $payment->booking->update(['status' => 'booked']);
                        }

                        break;

                    case 'EXPIRED':
                        $payment->update(['status' => $status]);
                        // Additional logic for EXPIRED status
                        break;

                    case 'FAILED':
                        $payment->update(['status' => $status]);
                        // Additional logic for FAILED status
                        break;
                }

                return response()->json(['success' => true]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the callback',
            ], 500);
        }
    }

}
