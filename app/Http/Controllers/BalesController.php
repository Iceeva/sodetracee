<?php

namespace App\Http\Controllers;

use App\Models\Bale;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;

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
        $qrCode = QrCode::size(200)->generate($url);
        $qrCodePath = public_path('images/qr_codes/' . $bale->reference . '.png');
        file_put_contents($qrCodePath, $qrCode);

        // Conversion en PDF
        $pdf = PDF::loadView('bales.qr-pdf', [
            'qrCodePath' => $qrCodePath,
            'reference' => $bale->reference
        ]);
        $pdfPath = public_path('images/qr_codes/' . $bale->reference . '.pdf');
        $pdf->save($pdfPath);

        return response()->download($pdfPath)->deleteFileAfterSend(true);
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
