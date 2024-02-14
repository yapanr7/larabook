<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'app_name' => 'Photostudio Booking',
            'app_tagline' => 'Booking Photo Jadi Lebih Mudah',
            'app_logo' => null,
            'app_favicon' => null,
            'app_background' => null,
            'enable_qris_payment' => true,
            'tripay_merchant_code' => 'YOUR_TRIPAY_MERCHANT_CODE',
            'tripay_api_key' => 'YOUR_TRIPAY_API_KEY',
            'tripay_private_key' => 'YOUR_TRIPAY_PRIVATE_KEY',
            'tripay_transaction_url' => 'https://tripay.co.id/api-sandbox/transaction/create',
        ]);
    }
}
