<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/login', function () {
    $status = session('status', 'Please log in to continue.');

    return response(
        '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>Login</title></head>'
        .'<body><p>'.e($status).'</p></body></html>'
    );
})->name('login');

Route::get('/health', function () {
    return response()->json(['ok' => true]);
});
