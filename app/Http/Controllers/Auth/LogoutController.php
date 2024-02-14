<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/')->with('success', 'Anda telah logout.');
        } catch (\Exception $e) {
            // Handle any exceptions that might occur during the logout process
            return redirect('/')->with('error', 'An error occurred during logout.');
        }
    }
}
