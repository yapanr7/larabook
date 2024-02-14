<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Setting;

class PaymentController extends Controller
{

    public function index($code)
    {

        $booking = Booking::where('code', $code)->first();
        $totalPaidAmount = $booking->payments->where('status', 'paid')->sum('amount');

        if ($totalPaidAmount >= $booking->package->price) {
            return redirect()->route('bookings.show', $code)->with('success', 'Pembayaran sudah lunas.');
        }
        $remainingPayment = $booking->package->price - $totalPaidAmount;
        $payment = Payment::where('booking_id', $booking->id)->where('status', 'unpaid')->latest()->first();

        if ($payment) {
            return redirect()->route('payment.pay', $code)->with('warning', 'Silahkan bayar terlebih dahulu.');
        }

        return view('payment.index', compact('booking' , 'remainingPayment', 'totalPaidAmount'));
    }

    public function process(Request $request, $code)
    {
        $booking = Booking::where('code', $code)->first();
        if (!$booking) {
            return redirect()->route('home')->with('error', 'Invalid payment reference.');
        }

        $payment_method = $request->payment_method;
        $payment_type = $request->payment_type;
        $totalPaidAmount = $booking->payments->where('status', 'paid')->sum('amount');
        $remainingAmount = $booking->package->price - $totalPaidAmount;

        if ($totalPaidAmount > 0 && $payment_type === 'partial') {
            return redirect()->back()->with('error', 'Pembayaran sebagian hanya dapat dilakukan satu kali.');
        }

        if ($payment_type === 'full' && $remainingAmount > 0) {
            $amount = $remainingAmount;
        } elseif ($payment_type === 'partial') {
            $amount = $booking->package->minimal_booking_price;
        } else {
            return redirect()->back()->with('error', 'Invalid payment type.');
        }

        if ($payment_method === 'qris') {

            $setting = Setting::latest()->first();

            $merchantCode = $setting->tripay_merchant_code ?? '';
            $apiKey = $setting->tripay_api_key ?? '';
            $privateKey =  $setting->tripay_private_key;
            $merchantRef  = $booking->code;
            $orderItems[] = [
                'sku' => $booking->package->id,
                'name' => $booking->package->name,
                'price' => $amount,
                'quantity' => 1,
            ];

            $signature = hash_hmac('sha256', $merchantCode . $merchantRef . $amount, $privateKey);
            $payload = [
                'method' => 'QRIS2',
                'merchant_ref' => $booking->code,
                'amount' => $amount,
                'customer_name' => $booking->user->name,
                'customer_email' =>  $booking->user->email,
                'customer_phone' => $booking->user->phone ?? '0',
                'order_items' => $orderItems,
                'callback_url' => route('callback'),
                'return_url' => route('payment.pay', $code),
                'expired_time' => strtotime('+1 day'), // Set the expiration time (24 hours from now)
                'signature' => $signature,
            ];
            // dd($signature);
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
            ])->timeout(60)->post($setting->tripay_transaction_url, $payload);

            // dd($response->json());

            $responseData = $response->json();

            if (!$response->successful()) {

                return redirect()->back()->with('error', $responseData['message']);
            }
            $response = $responseData['data'];
            // dd($response);
            $reference = $response['reference'];
            $merchant_ref = $response['merchant_ref'];
            $payment_name = $response['payment_name'];
            $callback_url = $response['callback_url'];
            $return_url = $response['return_url'];
            $checkout_url = $response['checkout_url'];
            $fee_merchant = $response['fee_merchant'];
            $fee_customer = $response['fee_customer'];
            $total_fee = $response['total_fee'];
            $amount_received = $response['amount_received'];
            $pay_code = $response['pay_code'];
            $pay_url = $response['pay_url'];
            $qr_string = $response['qr_string'];
            $qr_url = $response['qr_url'];
            $expired_time = $response['expired_time'];
            $instructions = $response['instructions'];
            $order_items = $response['order_items'];
            $status = $response['status'];


            $payment = new Payment();
            $payment->booking_id = $booking->id;
            $payment->user_id = $booking->user_id;
            $payment->pay_code = $pay_code;
            $payment->pay_url = $pay_url;
            $payment->callback_url = $callback_url;
            $payment->checkout_url = $checkout_url;
            $payment->amount = $amount;
            $payment->method = $payment_method;
            $payment->qr_string = $qr_string;
            $payment->qr_url = $qr_url;
            $payment->expired_time = $expired_time;
            $payment->save();

        } else if ($payment_method === 'bank') {

            $payment = new Payment();
            $payment->booking_id = $booking->id;
            $payment->user_id = $booking->user_id;
            $payment->method = $payment_method;
            $payment->amount = $amount;
            // dd($payment);
            $payment->save();


        }


        return redirect()->route('payment.pay', $code)->with('success', 'pembyaran dibuat mohon lakukan pembayaran.');
    }

    public function pay($code)
    {
        $booking = Booking::where('code', $code)->first();
        $totalPaidAmount = $booking->payments->where('status', 'paid')->sum('amount');

        if ($totalPaidAmount >= $booking->package->price) {
            return redirect()->route('bookings.show', $code)->with('success', 'Pembayaran sudah lunas.');
        }


        if (!$booking) {
            return redirect()->route('home')->with('error', 'Invalid booking reference.');
        }
        $currentUser = Auth::user();

        $payment = Payment::where('booking_id', $booking->id)->where('status', 'unpaid')->latest()->first();

        // if (!$payment) {
        //     return redirect()->route('payment.index', ['code' => $booking->code])->with('error', 'Buat transaksi terlebih dahulu.');
        // }

        $banks = Bank::all();
        return view('payment.pay', compact('booking', 'payment', 'banks'));
    }

}
