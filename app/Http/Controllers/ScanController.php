<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ScanController extends Controller
{
    public function index()
    {
        return view('scanner');
    }

    public function generateQRCode(Request $request)
    {
        $reference = $request->input('reference');

        if (!$reference) {
            return back()->withErrors(['reference' => 'La référence est requise.']);
        }

        // Génération du QR Code
        $qrCode = QrCode::format('png')->size(300)->generate($reference);

        // Enregistrer le QR Code en tant que fichier
        $fileName = 'qrcode_' . time() . '.png';
        Storage::disk('public')->put($fileName, $qrCode);

        // Générer un lien vers le fichier QR Code
        $qrCodeUrl = asset('storage/' . $fileName);

        return view('scanner.result', ['qrCodeUrl' => $qrCodeUrl]);
    }

    public function scan(Request $request)
    {
        // Logic for scanning and generating QR code
    }
}
