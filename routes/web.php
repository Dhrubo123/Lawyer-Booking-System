<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AvailabilityController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\BookingController;
use Inertia\Inertia;
use App\Models\Setting;

Route::get('/', function () {
    return Inertia::render('Public/Home', ['contact' => ['phone' => Setting::valueFor('phone'), 'whatsapp' => Setting::valueFor('whatsapp')], 'branding' => ['logo_url' => Setting::valueFor('logo_url'), 'favicon_url' => Setting::valueFor('favicon_url')]]);
})->name('home');

Route::get('/book-appointment', [BookingController::class, 'create'])->name('book-appointment');
Route::get('/available-slots', [BookingController::class, 'slots'])->name('available-slots');
Route::post('/appointments', [BookingController::class, 'store'])->name('appointments.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])
        ->middleware('guest')
        ->name('login');
    Route::post('/login', [AuthController::class, 'store'])->middleware('guest')->name('login.store');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', fn () => to_route('admin.dashboard'));

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/appointments', [AdminController::class, 'appointments'])
            ->name('appointments');
        Route::get('/appointments/{appointment}', [AdminController::class, 'showAppointment'])
            ->name('appointments.show');
        Route::patch('/appointments/{appointment}/status', [AdminController::class, 'updateAppointmentStatus'])->name('appointments.status');

        Route::get('/calendar', [AdminController::class, 'calendar'])
            ->name('calendar');

        Route::get('/availability', [AvailabilityController::class, 'index'])->name('availability');
        Route::post('/availability', [AvailabilityController::class, 'store'])->name('availability.store');
        Route::put('/availability/{availabilitySchedule}', [AvailabilityController::class, 'update'])->name('availability.update');
        Route::delete('/availability/{availabilitySchedule}', [AvailabilityController::class, 'destroy'])->name('availability.destroy');
        Route::post('/availability/dates', [AvailabilityController::class, 'storeDate'])->name('availability.dates.store');
        Route::put('/availability/dates/{availabilityDate}', [AvailabilityController::class, 'updateDate'])->name('availability.dates.update');
        Route::delete('/availability/dates/{availabilityDate}', [AvailabilityController::class, 'destroyDate'])->name('availability.dates.destroy');

        Route::get('/clients', [AdminController::class, 'clients'])
            ->name('clients');

        Route::get('/services', [AdminController::class, 'services'])
            ->name('services');

        Route::get('/tax-insights', [AdminController::class, 'insights'])
            ->name('insights');

        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    });
});
