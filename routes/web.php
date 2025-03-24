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
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\BaleController;
use App\Http\Controllers\UsersController;
use Intervention\Image\Facades\Image;


require __DIR__.'/auth.php';

Route::get('/login', function () {
    return view('auth.login'); // ici ok
})->name('login'); // ici ok


// Page d'accueil : bales.blade.php
Route::get('/', fn() => view('bales.bales'))->name('home'); // ici ok

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']); // ok
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // ici ok

Route::get('bales/scanner', [ScanController::class, 'index'])->name('scanner')->middleware('auth'); //touche pas
Route::post('/scanner', [ScanController::class, 'scan'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin'); // ici ok
    Route::post('/admin/bales', [AdminController::class, 'storeBale'])->name('admin.bales.store');
        Route::put('/admin/bales/{id}', [AdminController::class, 'updateBale'])->name('admin.bales.update');
        Route::delete('/admin/bales/{id}', [AdminController::class, 'destroyBale'])->name('admin.bales.destroy');
        Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    Route::resource('bales', BalesController::class);
    Route::resource('users', UsersController::class);

    Route::get('/agent/scan', [AgentController::class, 'scanPage'])->name('agent.scan');
    Route::post('/agent/scan', [AgentController::class, 'generateQRCode']);

    // bales
    Route::get('/bales/generate-qr', [BalesController::class, 'generateQrForm'])->middleware('restrict:agent')->name('bales.generate-qr');
    Route::post('/bales/generate-qr', [BalesController::class, 'generateQr'])->middleware('restrict:agent');
    Route::get('/bales/scan/{reference}', [BalesController::class, 'scan'])->middleware('restrict:buyer')->name('bales.scan');

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

// Routes pour la vérification d'email
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// c'est ici
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


Route::post('/scanner/generate', [ScanController::class, 'generateQRCode'])->name('scanner.generate');

