<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        // Mengambil data pengaturan dari database
        $settings = Setting::latest()->first();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'app_name' => 'required|string',
                'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'app_background' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'app_favicon' => 'nullable|image|mimes:png,ico,svg|max:2048',
                'app_tagline' => 'required|string',
                'enable_qris_payment' => 'boolean',
                'tripay_merchant_code' => 'required|string',
                'tripay_api_key' => 'required|string',
                'tripay_private_key' => 'required|string',
                'tripay_transaction_url' => 'required|url',
            ]);

            // Mengambil data pengaturan dari database
            $settings = Setting::first();

            // Mengupdate data pengaturan
            $settings->update([
                'app_name' => $request->app_name,
                'app_tagline' => $request->app_tagline,
                'enable_qris_payment' => $request->has('enable_qris_payment'),
                'tripay_merchant_code' => $request->tripay_merchant_code,
                'tripay_api_key' => $request->tripay_api_key,
                'tripay_private_key' => $request->tripay_private_key,
                'tripay_transaction_url' => $request->tripay_transaction_url,
            ]);

            // Mengunggah logo aplikasi jika ada
            if ($request->hasFile('app_logo')) {
                Storage::delete('public/logo/' . $settings->app_logo);
                $app_logo = $request->file('app_logo');
                $app_logo->storeAs('public/logo', $app_logo->hashName());
                $settings->update(['app_logo' => $app_logo->hashName()]);
            }

            if ($request->hasFile('app_background')) {
                Storage::delete('public/background/' . $settings->app_background);
                $app_background = $request->file('app_background');
                $app_background->storeAs('public/background', $app_background->hashName());
                $settings->update(['app_background' => $app_background->hashName()]);
            }

            // Mengunggah favicon jika ada
            if ($request->hasFile('app_favicon')) {
                Storage::delete('public/favicon/' . $settings->app_favicon);
                $app_favicon = $request->file('app_favicon');
                $app_favicon->storeAs('public/favicon', $app_favicon->hashName());
                $settings->update(['app_favicon' => $app_favicon->hashName()]);
            }

            return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil diperbarui.');
        } catch (\Exception $e) {
            // Tangani exception di sini
            return redirect()->route('admin.settings.index')->with('error', 'Gagal memperbarui pengaturan. Error: ' . $e->getMessage());
        }
    }

}
