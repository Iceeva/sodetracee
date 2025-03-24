<?php

namespace App\Http\Controllers;

use App\Models\Bale;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class BalesController extends Controller
{
    public function generateQrForm(): \Illuminate\View\View
    {
        return view('bales.generate-qr');
    }

    public function generateQr(Request $request)
    {
        $request->validate([
            'reference' => 'required|string'
        ]);

        $bale = Bale::where('reference', $request->reference)->firstOrFail();

        // URL à encoder dans le QR code
        $url = route('bales.scan', $bale->reference);

        // Génération du QR code
        $qrCode = QrCode::format('png')->size(200)->generate($url);

        // Création de l'image avec le QR code et la référence
        $qrCodeImage = Image::make($qrCode);
        $qrCodeImage->resize(200, 200);
        $qrCodeImage->text($bale->reference, 100, 220, function ($font) {
            $font->file(public_path('fonts/arial.ttf')); //  la police 
            $font->size(16);
            $font->align('center');
            $font->valign('top');
        });

        $qrCodePath = public_path('images/qr_codes/' . $bale->reference . '.png');
        $qrCodeImage->save($qrCodePath);

        return response()->download($qrCodePath)->deleteFileAfterSend(true);
    }

    public function scan($reference)
    {
        $bale = Bale::where('reference', $reference)->firstOrFail();

        // Vérifie si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('redirect', route('bales.scan', $reference));
        }

        // Vérification du rôle pour limiter les données
        $data = Auth::user()->role === 'buyer'
            ? $bale->only(['reference', 'quality', 'weight'])
            : $bale;

        return view('bales.scan', ['bale' => $data]);
    }
}
