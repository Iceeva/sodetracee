<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BalesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

// Routes publiques
Route::get('/', fn() => view('bales.bales'))->name('home');
Route::get('/bales', [BalesController::class, 'index'])->name('bales.index'); // Liste publique optionnelle
Route::get('/bales/scan/{reference}', [BalesController::class, 'scan'])->name('bales.scan'); // Accessible à tous, restrictions dans le contrôleur
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login')->middleware('guest');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest');
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register')->middleware('guest');
Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout')->middleware('auth');

// Routes protégées par l'authentification
Route::middleware('auth')->group(function () {
    Route::get('/bales/generate-qr', [BalesController::class, 'generateQrForm'])->middleware('restrict:agent')->name('bales.generate-qr');
    Route::post('/bales/generate-qr', [BalesController::class, 'generateQr'])->middleware('restrict:agent');

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

// Routes pour la vérification d'email
Route::get('/email/verify', fn() => view('auth.verify-email'))->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Un email de vérification a été envoyé !');
})->middleware('auth')->name('verification.send');