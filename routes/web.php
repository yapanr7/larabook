<?php

use App\Http\Controllers\Auth\OtpVerificationController;
use Illuminate\Support\Facades\Route;


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'store'])->name('login.store');
Route::get('/logout', [App\Http\Controllers\Auth\LogoutController::class, 'logout'])->name('logout');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'index'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'store'])->name('register.store');

Route::controller(App\Http\Controllers\Auth\VerificationController::class)->group(function () {
    Route::get('/email/verify', 'notice')->name('verification.notice');
});

// Route to show forgot password form
Route::get('/lupa-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showForgetPasswordForm'])
    ->name('forget.password.get');
// Route to process forgot password form
Route::post('/lupa-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'submitForgetPasswordForm'])
    ->name('forget.password.post');
Route::get('reset-password/{token}', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');


Route::post('/verify-otp', [OtpVerificationController::class, 'verify'])->name('verify-otp');
Route::get('/resend-otp', [OtpVerificationController::class, 'resend'])->name('resend-otp');

Route::get('packages', [App\Http\Controllers\PackageController::class, 'index'])->name('packages.index');
Route::get('packages/{slug}', [App\Http\Controllers\PackageController::class, 'show'])->name('packages.show');
Route::post('packages/booking', [App\Http\Controllers\PackageController::class, 'booking'])->name('packages.booking');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/booking', [App\Http\Controllers\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/payment/{code}', [App\Http\Controllers\PaymentController::class, 'index'])->name('payment.index');
    Route::post('/payment/{code}/process', [App\Http\Controllers\PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/{code}/pay', [App\Http\Controllers\PaymentController::class, 'pay'])->name('payment.pay');
    Route::get('/payment/{reference}', [App\Http\Controllers\BookingController::class, 'payment'])->name('bookings.payment');
    Route::post('/booking', [App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');
    Route::post('/booking/qris/{reference}', [App\Http\Controllers\BookingController::class, 'process_payment_qris'])->name('booking.process_payment_qris');
    Route::get('booking/{code}', [App\Http\Controllers\BookingController::class, 'show'])->name('bookings.show');
    Route::get('booking/{code}/cancel', [App\Http\Controllers\BookingController::class, 'cancel'])->name('bookings.cancel');
});



Route::get('/jadwal', [App\Http\Controllers\BookingController::class, 'viewEmptySchedule'])->name('bookings.jadwal');
Route::get('/get-available-slots', [App\Http\Controllers\PackageController::class, 'getAvailableSlots'])->name('bookings.getAvailableSlots');
Route::get('/get-dates', [App\Http\Controllers\PackageController::class, 'getDates'])->name('bookings.getDates');



Route::group(['middleware' => 'is_admin', 'prefix' => 'admin'], function () {
    Route::get('dashboard', App\Http\Controllers\Admin\DashboardController::class)->name('admin.dashboard');
    Route::delete('gallery/{gallery}', [App\Http\Controllers\Admin\PackageController::class, 'deleteGallery'])->name('admin.galleries.delete');
    Route::resource('packages', App\Http\Controllers\Admin\PackageController::class)->names('admin.packages');
    Route::post('packages/{package}/add-gallery', [App\Http\Controllers\Admin\PackageController::class, 'addGallery'])->name('admin.galleries.store');
    Route::post('booking/change_status', [App\Http\Controllers\Admin\BookingController::class, 'changeStatus'])->name('admin.bookings.change_status');
    Route::post('booking/change_download', [App\Http\Controllers\Admin\BookingController::class, 'changeDownloadLink'])->name('admin.bookings.change_download');
    Route::resource('booking', App\Http\Controllers\Admin\BookingController::class)->names('admin.bookings');
    Route::resource('banks', App\Http\Controllers\Admin\BankController::class)->names('admin.banks');
    Route::resource('payments', App\Http\Controllers\Admin\PaymentController::class)->names('admin.payments');
    Route::get('users/data', [App\Http\Controllers\Admin\UserController::class, 'getUsersData'])->name('admin.users.data');
    Route::post('users/{user}/verify', [App\Http\Controllers\Admin\UserController::class, 'verify'])->name('admin.users.verify');
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->names('admin.users');
    Route::get('settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings.index');
    Route::put('settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');
});
