<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


Route::get('/', function () {
    if (!Auth::check()) {
        return redirect('/login');
    }
    return view('beranda');
});
Route::post('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');

Route::get('/register', function () {
    if (Auth::check()) {
        return redirect('/');
    }
    return view('register');
})->name('register');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);

Route::get('/about', function () {
    if (!Auth::check()) {
        return redirect('/login');
    }
    return view('beranda');
});

Route::get('/feedback', [App\Http\Controllers\FeedbackController::class, 'index'])->middleware('auth');
Route::post('/feedback', [App\Http\Controllers\FeedbackController::class, 'store'])->name('feedback.store')->middleware('auth');
Route::get('/fetchFeedback', [App\Http\Controllers\FeedbackController::class, 'fetchFeedback'])->name('fetch.feedback')->middleware('auth');
