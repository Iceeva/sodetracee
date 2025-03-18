<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


Route::get('/bales/{reference}', function ($reference) {
    $bale = \App\Models\Bale::where('reference', $reference)->firstOrFail();
    return response()->json([
        'redirect' => route('bales.scan', $reference),
        'public_data' => [
            'reference' => $bale->reference,
            'quality' => $bale->quality,
            'weight' => $bale->weight,
        ]
    ]);
});