<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [BookingController::class, 'index'])->name('home');
Route::post('/booking', [BookingController::class, 'store']);
Route::post('/booking/check', [BookingController::class, 'checkBooking']);
Route::get('/booking/list', [BookingController::class, 'show'])->name('list');
