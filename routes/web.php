<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('login', [AuthenticatedSessionController::class, 'login']);
Route::post('register', [AuthenticatedSessionController::class, 'register']);
Route::post('logout', [AuthenticatedSessionController::class, 'logout']);

// Email Verification Routes
/*Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/resend', [VerificationController::class, 'resend'])
    ->middleware(['throttle:6,1'])
    ->name('verification.resend');*/




//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::view('/{any?}', 'main-view')
    ->name('dashboard')
    ->where('any', '.*');
