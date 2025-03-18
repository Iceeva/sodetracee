<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BalesController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

// Routes d'authentification générées par Breeze
require __DIR__.'/auth.php';

Route::get('/login', function () {
    return view('auth.login'); // Vérifie que ce fichier existe bien
})->name('login');

// Page d'accueil : bales.blade.php
Route::get('/', fn() => view('bales.bales'))->name('home');

// Routes protégées par l'authentification
Route::middleware('auth')->group(function () {
    Route::get('/bales/generate-qr', [BalesController::class, 'generateQrForm'])->middleware('restrict:agent')->name('bales.generate-qr');
    Route::post('/bales/generate-qr', [BalesController::class, 'generateQr'])->middleware('restrict:agent');
    Route::get('/bales/scan/{reference}', [BalesController::class, 'scan'])->middleware('restrict:buyer')->name('bales.scan');

    // Routes Admin
    Route::middleware('restrict:admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');
        Route::post('/admin/bales', [AdminController::class, 'storeBale'])->name('admin.bales.store');
        Route::put('/admin/bales/{id}', [AdminController::class, 'updateBale'])->name('admin.bales.update');
        Route::delete('/admin/bales/{id}', [AdminController::class, 'destroyBale'])->name('admin.bales.destroy');
        Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    });

    // Routes pour le profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route de déconnexion
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Routes pour la vérification d'email
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Un email de vérification a été envoyé !');
})->middleware('auth')->name('verification.send');

Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');
