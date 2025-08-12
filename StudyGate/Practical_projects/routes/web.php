<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstrumentController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\UserController;

route::get('/', function () {
    return view('dashboard.index');
});                     

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::resource('instruments', InstrumentController::class);
Route::resource('campuses', CampusController::class);
Route::resource('labs', LabController::class);
Route::resource('buildings', BuildingController::class);
Route::resource('users', UserController::class);

// الحجوزات
Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

use App\Http\Controllers\Auth\LoginController;

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');





