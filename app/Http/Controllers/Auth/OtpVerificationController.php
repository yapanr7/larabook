<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class OtpVerificationController extends Controller
{
    public function verify(Request $request)
    {
        // Validasi input OTP
        $request->validate([
            'digit_1' => 'required|digits:1',
            'digit_2' => 'required|digits:1',
            'digit_3' => 'required|digits:1',
            'digit_4' => 'required|digits:1',
        ]);

        // Menggabungkan digit menjadi satu OTP
        $otp = $request->input('digit_1') . $request->input('digit_2') . $request->input('digit_3') . $request->input('digit_4');
        // Cek kecocokan OTP di database
        // dd($otp);

        $user = auth()->user();
        if (!$user || $user->otp !== $otp) {
            // Mengembalikan dengan pesan error
            return Redirect::back()->with(['warning' => 'Kode OTP tidak valid.']);
        }
        $user->email_verified_at = now();
        $user->otp = null;
        $user->save();
        flash()->addSuccess('Selamat akun anda berhasil diverifikasi');
        Auth::login($user);
        return redirect()->route('home');
    }


    public function resend(Request $request)
    {

        // Cari pengguna berdasarkan alamat email
        $user = auth()->user();

        // Kirim ulang OTP ke pengguna
        $otp = $this->generateRandomOTP();
        $user->otp = $otp;
        $user->save();

        Mail::to($user->email)->send(new OtpMail($otp));
        // Redirect kembali dengan pesan sukses
        flash()->addSuccess('OTP telah dikirim ulang ke alamat email Anda.');
        return redirect()->back();
    }

    // Metode untuk menghasilkan OTP acak
    private function generateRandomOTP($length = 4) {
        $characters = '0123456789';
        $otp = '';

        for ($i = 0; $i < $length; $i++) {
            $otp .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $otp;
    }
}
