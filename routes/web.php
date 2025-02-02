<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StuffController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'auth.session', 'verified'])->group(function () {
    Route::get('/stuffs', [StuffController::class, 'index'])->name('stuffs.index');
    Route::get('/stuffs/create', [StuffController::class, 'create']);
    Route::post('/stuffs/store', [StuffController::class, 'store']);
    Route::get('/stuffs/{id}', [StuffController::class, 'show']);
    Route::get('/stuffs/{id}/edit', [StuffController::class, 'edit']);
    Route::put('/stuffs/update/{id}', [StuffController::class, 'update']);
    Route::delete('/stuffs/delete/{id}', [StuffController::class, 'delete']);
});

//
// Auth Controller //
//

Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/email/verify', function () {return view('auth.verify');})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function(EmailVerificationRequest $request){
    $request->fulfill();
    return redirect()->route('login');
})->middleware('auth','signed')->name('verification.verify');

Route::post('/email/verification-notification', function(Request $request){
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->name('verification.send');

Route::get('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::get('/logout', [AuthController::class, 'logout']);

// User Controller

Route::middleware(['auth', 'auth.session', 'verified'])->group(function () {
    Route::get('/users', [UserController::class, 'index']);
});
