<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        $profile = Auth::user();
        return view('profile.index', ['profile' => $profile]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->route('profile.index')
                ->withErrors($validator)
                ->withInput();
        }

        $user->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
        ]);

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }

    // Add a method to handle password change
    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('profile.index')
                ->withErrors($validator)
                ->withInput();
        }

        if (!password_verify($request->input('current_password'), $user->password)) {
            return redirect()->route('profile.index')->with('error', 'Current password is incorrect.');
        }

        $user->update([
            'password' => bcrypt($request->input('new_password')),
        ]);

        return redirect()->route('profile.index')->with('success', 'Password changed successfully.');
    }
}
